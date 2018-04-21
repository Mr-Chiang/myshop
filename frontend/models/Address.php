<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property int $id
 * @property int $user_id 用户id
 * @property string $province 省
 * @property string $city 市
 * @property string $area 区
 * @property string $Detailed 详细地址
 * @property string $tel 联系电话
 * @property int $status 是否默认地址
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['province', 'city', 'area', 'detailed', 'tel','name'], 'required'],
            [['tel'],'match','pattern'=>'/0?(13|14|15|17|18|19)[0-9]{9}/'],
            [['status'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'province' => '省份/直辖市',
            'city' => '市/直辖市',
            'area' => '区/县',
            'detailed' => '详细地址',
            'tel' => '联系电话',
            'status' => '是否默认地址',
            'name' => '收货人'
        ];
    }
}
