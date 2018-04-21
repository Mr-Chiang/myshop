<?php
/**
 * Created by PhpStorm.
 * User: ASUS-F550L
 * Date: 2018/3/27
 * Time: 12:37
 */

namespace frontend\models;


use yii\base\Model;

class LoginForm extends Model
{
     public $username;
     public $password;
     public $code;
    //是否记住密码
    public $rememberMe;

    public function rules()
    {
        return [
            [['username','password','code'],'required'],
            [['code'],'captcha',"captchaAction" => "user/code"],
            [['rememberMe'],'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'code' => '验证码'
        ];
    }
}