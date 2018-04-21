<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $address_id 用户地址
 * @property int $user_id 用户id
 * @property string $province 省份
 * @property string $city 城市
 * @property string $area 详细地址
 * @property int $pay 支付方式
 * @property int $order_id 订单id
 * @property int $create_time 生成时间
 * @property string $total 订单总金额
 * @property int $status 订单状态
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'user_id', 'pay_id'], 'required'],
            [['total'], 'number'],
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
            'province' => '省份',
            'city' => '城市',
            'area' => '详细地址',
            'pay' => '支付方式',
            'delivery' => '配送方式',
            'sn' => '订单id',
            'create_time' => '生成时间',
            'total' => '订单总金额',
            'status' => '订单状态',
        ];
    }
}
