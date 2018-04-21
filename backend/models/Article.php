<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "Article".
 *
 * @property int $id
 * @property string $title 文章标题
 * @property int $sort 文章排序
 * @property string $intro 文章简介
 * @property int $status 文章状态
 * @property int $cate_id 分类id
 * @property int $create_time 文章创建时间
 * @property int $update_time 文章修改时间
 * @property int $is_display 软删除
 */
class Article extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'status', 'cate_id', 'create_time', 'update_time', 'is_display'], 'integer'],
            [['intro','title'], 'string', 'max' => 255],
            [[ 'status', 'cate_id','intro','title','sort'], 'required'],
            [['title'],'unique'],
            [['sort'],'integer'],
            [['create_time','update_time'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '文章标题',
            'sort' => '文章排序',
            'intro' => '文章简介',
            'status' => '文章状态',
            'cate_id' => '分类id',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'is_display' => '软删除',
        ];
    }
}
