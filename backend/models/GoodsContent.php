<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_content".
 *
 * @property int $id
 * @property string $content 商品详情
 * @property int $goods_id 商品id
 * @property int $is_display 软删除
 */
class GoodsContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['is_display','goods_id'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '商品详情',
            'goods_id' => '商品id',
            'is_display' => '软删除',
        ];
    }
}
