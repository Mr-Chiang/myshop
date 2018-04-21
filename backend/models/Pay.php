<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pay".
 *
 * @property int $id
 * @property int $sn 编号
 * @property string $name 名称
 * @property int $sort 排序
 * @property string $intro 简介
 */
class Pay extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sn', 'name','price'], 'required'],
            [['sn', 'sort'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sn' => '编号',
            'name' => '名称',
            'sort' => '排序',
            'intro' => '简介',
            'price' => '价格'
        ];
    }
}
