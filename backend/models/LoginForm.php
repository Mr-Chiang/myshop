<?php
/**
 * Created by PhpStorm.
 * User: ASUS-F550L
 * Date: 2018/3/22
 * Time: 19:19
 */

namespace backend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $name;
    public $password;
    public $rememberMe;
    public function rules()
    {
        return [
          [['name','password'],'required'],
          [['remember'],'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' =>'用户名',
            'password' =>'密码',
            'remember' =>'是否记住密码'
        ];
    }

}