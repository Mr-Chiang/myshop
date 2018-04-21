<?php

namespace backend\models;

use backend\components\MenuQuery;
use creocoder\nestedsets\NestedSetsBehavior;
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name 分类名称
 * @property int $parent_id 父级id
 * @property string $intro 分类简介
 * @property int $left 左值
 * @property int $right 右值
 * @property int $tree 分组
 * @property string $is_display 软删除
 */
class Category extends \yii\db\ActiveRecord
{
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
                'leftAttribute' => 'left',
                'rightAttribute' => 'right',
                'depthAttribute' => 'depth',
            ],
        ];
    }
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find(){
        return new MenuQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id',  'tree'], 'integer'],
            [['name', 'intro',], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '分类名称',
            'parent_id' => '父级 ID',
            'intro' => '分类简介',
            'left' => '左值',
            'right' => '右值',
            'tree' => '分组',
            'depth' => '深度',
            'is_display' => '软删除',
        ];
    }

    public function getNameText(){
        return str_repeat('-',$this->depth*5).$this->name;
    }
}
