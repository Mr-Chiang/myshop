<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property int $type
 * @property string $description
 * @property string $rule_name
 * @property resource $data
 * @property int $created_at
 * @property int $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 * @property AuthItem[] $children
 * @property AuthItem[] $parents
 */
class AuthItem extends \yii\db\ActiveRecord
{

    //定义一个属性装载所有权限
    public $permissions;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name',], 'required'],
            [['name'],'unique'],
            [['description','permissions'],'safe']

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '名称',
            'description' => '描述',
            'permissions' => '权限列表'

        ];
    }

}
