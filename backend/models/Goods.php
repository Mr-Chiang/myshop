<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string $name 商品名称
 * @property int $sn 商品编号
 * @property int $create_time 创建时间
 * @property int $update_time 修改时间
 * @property int $status 是否上架
 * @property string $intro 商品简介
 * @property double $price 商品售价
 * @property int $sort 商品排序
 * @property int $brand_id 商品品牌
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','sn'], 'required'],
            [[ 'create_time', 'update_time', 'sort', 'brand_id'], 'integer'],
            [['price','market_price','category_id','num'], 'number'],
            [['sn'],'unique'],
            [['name', 'intro'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 4],
            [['logo','sales_id'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'sn' => '商品编号',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '商品状态',
            'intro' => '商品简介',
            'price' => '商品售价',
            'sort' => '商品排序',
            'brand_id' => '商品品牌',
            'logo' => '商品封面',
            'market_price' => '市场价',
            'category_id' => '商品分类',
            'sales_id' => '商品'
        ];
    }

    public function getImgs(){
        return $this->hasMany(GoodsImages::className(),['goods_id'=>'id']);
    }
}
