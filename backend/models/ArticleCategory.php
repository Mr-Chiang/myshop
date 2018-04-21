<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_category".
 *
 * @property int $id
 * @property string $name 分类名称
 * @property string $intro 分类简介
 * @property int $status 分类状态：0禁用，1激活
 * @property int $is_help 是否帮助类：0否，1是
 * @property int $sort 分类排序
 */
class ArticleCategory extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'is_help', 'sort'], 'integer'],
            [['name', 'intro'], 'string', 'max' => 255],
            [['name'],'unique'],
            [['is_display'],'safe']
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
            'intro' => '分类简介',
            'status' => '分类状态',
            'is_help' => '是否帮助类',
            'sort' => '分类排序',
        ];
    }
}
