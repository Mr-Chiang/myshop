<?php

namespace backend\controllers;

use backend\models\AuthItem;
use yii\helpers\ArrayHelper;
use yii\web\Request;

class RoleController extends \yii\web\Controller
{
    /**角色列表
     * @return string
     */
    public function actionIndex()
    {
        //创建auth对象
        $auth = \Yii::$app->authManager;
        //获取所有角色
        $pers = $auth->getRoles();

        return $this->render('index',compact('pers'));
    }

    /**
     * 角色添加
     * @return string|\yii\web\Response
     */
    public function actionAdd(){
        //创建模型对象
        $model = new AuthItem();
        $request = new Request();
        //创建auth对象
        $auth = \Yii::$app->authManager;
        //得到所有权限
        $pers = $auth->getPermissions();
        $pers = ArrayHelper::map($pers,'name','description');


        if($model->load($request->post()) && $model->validate()){
            //创建角色
            $role = $auth->createRole($model->name);
            //设置描述
            $role->description = $model->description;
//        角色入库
            if ($auth->add($role)) {
                //给当前角色添加权限
                if($model->permissions) {
                    foreach ($model->permissions as $per) {
                        //通过权限名称得到权限对象
                        $per = $auth->getPermission($per);
                        $auth->addChild($role, $per);
                    }
                }
                \Yii::$app->session->setFlash('success','角色添加成功');

            }else{
                \Yii::$app->session->setFlash('danger','角色添加失败');
            }
            return $this->refresh();

        }
        //显示视图
        return $this->render('add',compact("model",'pers'));

    }

    /**
     * 编辑角色
     * @param $name 角色名称
     * @return string|\yii\web\Response
     */
    public function actionEdit($name){
        //创建模型对象
        $model = AuthItem::findOne($name);
        $request = new Request();
        //创建auth对象
        $auth = \Yii::$app->authManager;
        //得到所有权限
        $pers = $auth->getPermissions();
        $pers = ArrayHelper::map($pers,'name','description');
        $model->permissions = $auth->getPermissionsByRole($name);
        $model->permissions = array_keys($model->permissions);

        if($model->load($request->post()) && $model->validate()){
            //得到角色
            $role = $auth->getRole($model->name);
            //设置描述
            $role->description = $model->description;
//        更新角色
            if ($auth->update($model->name,$role)) {
                //删除当前角色对应的所有权限
                $auth->removeChildren($role);
                if($model->permissions) {
                    //给当前角色添加权限
                    foreach ($model->permissions as $per) {
                        //通过权限名称得到权限对象
                        $per = $auth->getPermission($per);
                        $auth->addChild($role, $per);
                    }
                }
                \Yii::$app->session->setFlash('success','角色编辑成功');

            }else{
                \Yii::$app->session->setFlash('danger','角色编辑失败');
            }
            return $this->redirect('index');

        }
        //显示视图
        return $this->render('add',compact("model",'pers'));

    }

    /**
     * 删除角色
     * @param $name 角色名称
     */
    public function actionDel($name){
//        var_dump($name);exit;
        //创建auth对象
        $auth = \Yii::$app->authManager;
        //找到角色
        $per = $auth->getRole($name);
        //删除角色
        if ($auth->remove($per)) {
            \Yii::$app->session->setFlash('success','删除角色成功');
        }else{
            \Yii::$app->session->setFlash('danger','删除角色失败');
        }
        return $this->refresh();

    }
}
