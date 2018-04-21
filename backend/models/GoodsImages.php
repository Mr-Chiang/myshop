<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_images".
 *
 * @property int $id
 * @property int $goods_id 商品id
 * @property string $path 图片路径
 * @property int $is_display 软删除
 */
class GoodsImages extends \yii\db\ActiveRecord
{
    public $images;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'is_display'], 'integer'],
            [['path'], 'string', 'max' => 255],
            [['images'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品id',
            'path' => '图片路径',
            'is_display' => '软删除',
        ];
    }
}
