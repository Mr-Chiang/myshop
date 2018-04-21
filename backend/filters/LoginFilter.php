<?php
/**
 * Created by PhpStorm.
 * User: ASUS-F550L
 * Date: 2018/3/20
 * Time: 21:58
 */

namespace backend\filters;


use yii\base\ActionFilter;
use yii\helpers\Url;
use yii\web\Controller;

class LoginFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        $identity = \Yii::$app->user->identity;
//        var_dump($identity);exit;
        if(!$identity){
            if( \Yii::$app->controller->action->id != 'login'){
                header("Location:http://admin.shop.com/admin/login");exit;
            }
//            return \Yii::$app->user->loginRequired();exit;

        }else{
            return true;
        }
        return parent::beforeAction($action);
    }

}