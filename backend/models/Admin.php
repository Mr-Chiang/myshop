<?php
/**
 * Created by PhpStorm.
 * User: ASUS-F550L
 * Date: 2018/3/20
 * Time: 22:59
 */

namespace backend\models;


use yii\db\ActiveRecord;
use yii\web\Cookie;
use yii\web\IdentityInterface;

class Admin extends ActiveRecord implements IdentityInterface
{

    //是否记住密码
    public $rememberMe;
    //所有角色
    public $roles;
    public static function tableName()
    {
        return 'admin';
    }

    public function rules()
    {
        return [
            [['name'],'required'],
            [['name','logo','auth_key','rememberMe','status','intro'],'safe'],
            [['status'],'requiredByASpecial'],
            [['roles'],'safe'],
            [['password'],'required','on'=>['add']],
            [['password'],'safe','on'=>['edit']],

        ];
    }

    public function scenarios()
    {
       $scenarios = parent::scenarios();
//       var_dump($parent);
        $scenarios['edit'] = ['password','name','status','logo','auth_key','rememberMe','intro'];
        $scenarios['add'] = ['password','name','status','logo','auth_key','rememberMe','intro'];
       return $scenarios;
    }


    public function attributeLabels()
    {
        return [
            'name' => '用户名',
            'password' => '密码',
            'intro' => '简介',
            'logo' => '头像',
            'auth_key' => '用户秘钥',
            'rememberMe' => '是否记住密码',
            'status' => '状态',
            'roles' => '角色列表'
        ];
    }


    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        // TODO: Implement getId() method.
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
        return $this->getAuthKey() === $authKey;
    }


    //自定义验证规则：当前登录用户不能禁用自己
    public function requiredByASpecial($attribute, $params)
    {
        if(\Yii::$app->user->getId() == $this->id && $this->status==0){
            $this->addError($attribute, "不能禁用自己");
        }
    }
}