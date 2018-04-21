<?php

namespace frontend\controllers;

use frontend\components\ShopCart;
use frontend\models\Cart;
use frontend\models\ContactForm;
use frontend\models\User;
use frontend\models\LoginForm;
use Mrgoon\AliSms\AliSms;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

class UserController extends \yii\web\Controller
{
    public function init(){
        $this->enableCsrfValidation = false;
    }


    /**
     * 验证码
     * @return string|\yii\web\Response   wdcp
     */
    public function actions()
    {
        return [
            'code' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength' => 3,
                'minLength' => 3,
            ],
        ];
    }


    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 用户注册
     */
    public function actionReg(){
        $request = \Yii::$app->request;
        //判断传值方式
        if($request->isPost){
            $model = new User();
            //绑定数据
            $model->load($request->post());
            if ($model->validate()) {
                $model->password_hash = \Yii::$app->security->generatePasswordHash($model->password);
                //保存数据
                if ($model->save(false)) {
                    $data = [
                        'message' => '注册成功',
                        'status' => 1,
                        'url' => '/user/login'
                    ];
                    return Json::encode($data);
                }

            }else{
                $data = [
                  'message' => $model->errors,
                  'status' => 0,
                  'url' => null
                ];

                return Json::encode($data);
            }

        }
        return $this->render('reg');
    }

    /**
     * 手机验证码
     * @param $mobile 手机号码
     */
    public function actionCaptcha($mobile){
        //生成验证码
        $code = rand(100000,999999);
        $config = [
            'access_key' => 'LTAILU6kvrJ4Zp7O',
            'access_secret' => 'EQCIjQwrEdOaLfZRk3k4uLtB2nZGLI',
            'sign_name' => '17寻乐',
        ];

        $aliSms = new AliSms();
        $response = $aliSms->sendSms($mobile, 'SMS_128636271', ['code'=> $code], $config);
        //记录验证码
        $session = \Yii::$app->session;
        $session->set('tel_'.$mobile,$code);
        return Json::encode($session->get('tel_'.$mobile));
    }


    /**
     * 用户登录
     * @return string
     */
    public function actionLogin(){
        $model = new LoginForm();
        $request = \Yii::$app->request;
        if($request->isPost) {
            if ($model->load($request->post()) && $model->validate()) {
//            return $model->rememberMe;
                //通过用户名查找实例
                $admin = User::find()->where(['username' => $model->username])->one();
                if($admin && $admin->status==10){
                    //验证密码
                    if(\Yii::$app->security->validatePassword($model->password,$admin->password_hash)){

                        $admin->login_ip = ip2long(\Yii::$app->request->userIP);
                        $admin->login_at= time();
                        //判断是否记住密码
                        $admin->auth_key = \Yii::$app->security->generateRandomString();
                        \Yii::$app->user->login($admin, $model->rememberMe?3600*24*7:0);
                        //保存数据
                        $admin->save(false);
                        $data = [
                            'message' => '登录成功',
                            'status' => 1,
                            'url' => null
                        ];
                        //将购物车中商品加入到用户库中
                        $cookies = new ShopCart();
                        if($cookies->get()){
                            foreach ($cookies->get() as $kk=>$vv){
                                //判断库中是否含有此商品
                                $cookies->loginCart($kk,$vv);
                                //销毁cookie数据
                                $cookies->del($kk)->save();
                            }
                        }
                        return Json::encode($data);
                    }else{
//
                        $data = [
                            'name' => 'password',
                            'message' => '用户密码错误',
                            'status' => 2,
                            'url' => null
                        ];
                        return Json::encode($data);
                    }
                }else{
                    $data = [
                        'name' => 'username',
                        'message' =>  '用户不存在或已禁用',
                        'status' => 2,
                        'url' => null
                    ];
                    return Json::encode($data);
                }

            } else {
                $data = [
                    'message' => $model->errors,
                    'status' => 0,
                    'url' => null
                ];
                return Json::encode($data);
            }
        }
        return $this->render('login');
    }

    public function actionLogout($id){
        $user = User::findOne(['id'=>$id]);
        //注销用户
        \Yii::$app->user->logout($user);
        return $this->redirect('/index/index');
    }

}
