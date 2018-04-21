<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property int $id
 * @property int $user_id 用户id
 * @property int $goods_id 商品id
 * @property int $goods_num 商品数量
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'goods_id', 'goods_num'], 'required'],
            [['user_id', 'goods_id', 'goods_num'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'goods_id' => '商品id',
            'goods_num' => '商品数量',
        ];
    }
}
