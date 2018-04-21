<?php
/**
 * Created by PhpStorm.
 * User: ASUS-F550L
 * Date: 2018/3/21
 * Time: 21:59
 */

namespace backend\controllers;


use backend\models\Admin;
use Codeception\Verify;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

class VerifyController extends Controller
{

     //判断当前用户权限
    public function beforeAction($action)
    {
        //如果未登录，则直接返回
//        if(\Yii::$app->user->isGuest){
//            \Yii::$app->session->setFlash('danger','你个无名氏，先登录在说话！！！');
//            return $this->redirect(['admin/login']);exit;
//        }
        //判断当前用户权限
//        if(!\Yii::$app->user->can($action->uniqueId)){
//            \Yii::$app->session->setFlash('danger','我是你想看就能看的吗，有本事找人给你权限啊！！！');
//            return $this->redirect(['admin/index']);exit;
//        }
        return true;
    }
}