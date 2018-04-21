<?php
/**
 * Created by PhpStorm.
 * User: ASUS-F550L
 * Date: 2018/3/20
 * Time: 22:55
 */

namespace backend\controllers;


use backend\filters\LoginFilter;
use backend\models\Admin;
use backend\models\LoginForm;
use function PHPSTORM_META\map;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\Request;

class AdminController extends Controller
{
    public $defaultAction = 'index';


    public function behaviors()
    {
        return [
            'LoginFilter' => [
                'class'=>LoginFilter::className(),
            ]
        ];
    }

    //管理员登录
    public function actionLogin()
    {

        $model = new LoginForm();
        $request = new Request();
//        echo \Yii::$app->security->generatePasswordHash('111');exit;
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            //验证数据
//            var_dump($model);exit;
            if ($model->validate()){
//                return $this->render('login',compact('model'));
                //判断用户是否存在
                $admin = Admin::find()->where(["name" => $model->name])->one();
            if ($admin && $admin->status) {
                //验证密码
                if (\Yii::$app->security->validatePassword($model->password, $admin->password)) {
                    $admin->last_time = time();
                    //存储用户密钥
                    $admin->auth_key = \Yii::$app->security->generateRandomString();
                    //存储ip
                    $admin->last_ip = ip2long(\Yii::$app->request->userIP);
                    \Yii::$app->user->login($admin, $model->rememberMe ? 3600 * 24 * 7 : 0);
                    $admin->save(false);
                    return $this->redirect(['admin/index']);
                }else{
                    $model->addError('password', '密码错误');
                }
            }else{
                $model->addError('name', '用户不存在或已禁用');
            }
        }
    }
        return $this->render('login',compact('model'));
    }

    //退出登录
    public function actionLogout(){
        \Yii::$app->user->logout();
        if(isset($_COOKIE['id'])){
            setcookie('id','',time()-1);
        }
        return $this->redirect(['admin/login']);
    }

    //管理员列表
    public function actionIndex(){
        $query = Admin::find()->where(['is_display'=>'1']);
        $countQuery = clone $query;
        $pages = new Pagination(['pageSize'=>4,'totalCount' => $countQuery->count()]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index',compact('model','pages'));
    }

    //添加管理员
    public function actionAdd(){
        $model = new Admin();
        $model->status=1;
        $request = new Request();
        //实例化auth对象
        $auth = \Yii::$app->authManager;
        //得到所有角色
        $roles = $auth->getRoles();
        $arr = [];
        foreach ($roles as $kk => $vv){
            $arr[$kk] = $kk;
        }
        $roles = $arr;
        $model->setScenario('add');
        if ($request->isPost) {

            //绑定数据
            $model->load($request->post());
                $model->roles = $request->post()["Admin"]['roles']?$request->post()["Admin"]['roles']:"";
            //后台验证
            if ($model->validate()) {
                $model->create_time = time();
                $model->password = \Yii::$app->security->generatePasswordHash($model->password);
                $model->update_time = time();
                //保存数据
                if ($model->save()) {
                    //给角色指派用户
                    if($model->roles){
                        //得到用户id
                        $id = \Yii::$app->db->getLastInsertID();
                        foreach ($model->roles as $role){
                            //通过角色名称找到角色
                            $role = $auth->getRole($role);
                            //将用户指派给角色
                            $auth->assign($role,$id);
                        }
                    }

                    \Yii::$app->session->setFlash('success','添加成功');
                }else{
                    \Yii::$app->session->setFlash('danger','添加失败');
                }
            }
        }
        return $this->render('add',compact('model','roles'));
    }

    //编辑管理员
    public function actionEdit($id){
        $model = Admin::findOne($id);
        $request = new Request();
        //得到所有角色
        $auth = \Yii::$app->authManager;
        $roles = $auth->getRoles();
        $arr = [];
        foreach ($roles as $kk => $vv){
            $arr[$kk] = $kk;
        }
        $roles = $arr;
        //通过用户id得到用户权限
        $pers = $auth->getRolesByUser($id);
        $arr = [];
        foreach ($pers as $kk => $vv){
            $arr[$kk] = $kk;
        }
        $model->roles = $arr;
        $model->setScenario('edit');
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            $model->roles = $request->post()["Admin"]['roles']?$request->post()["Admin"]['roles']:"";
//            var_dump($model->logo);exit;
            //后台验证
            if ($model->validate()) {
                $admin = Admin::findOne($id);
                $str = $admin->password;
                if($model->password){
                    $model->password = \Yii::$app->security->generatePasswordHash($model->password);
                }else{
                    $model->password = $str;
                }
                $model->update_time = time();
                //保存数据
                if ($model->save()) {
                    //删除用户所有角色
                    $res = \Yii::$app->db->createCommand('delete from auth_assignment where user_id='.$id)->query();
//                   var_dump($model->roles);exit;
                    //给用户重新指派角色
                    if($model->roles) {
                        //修改用户角色
                        foreach ($model->roles as $role) {
                            //通过角色名称找到角色
                            $role = $auth->getRole($role);
                            //将用户指派给角色
                            $auth->assign($role, $id);
                        }
                    }
                    \Yii::$app->session->setFlash('success','修改成功');
                    return $this->redirect(['admin/index']);
                }else{
                    \Yii::$app->session->setFlash('danger','修改失败');
                }
            }
        }
        return $this->render('add',compact('model','roles'));
    }

    //删除管理员
    public function actionDel($id){
        $model = Admin::findOne($id);
        $user_id = \Yii::$app->user->identity->getId();
        if($user_id == $id){
            \Yii::$app->session->setFlash('danger','不能删除当前登录用户');
            return $this->redirect(['admin/index']);
        }

        $model->is_display = 0;
        if ($model->save(false)) {
            \Yii::$app->session->setFlash('success','删除成功');
        }else{
            \Yii::$app->session->setFlash('danger','删除失败');
        }
        return $this->redirect(['admin/index']);
    }

}