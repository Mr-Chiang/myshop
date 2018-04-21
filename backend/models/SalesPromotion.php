<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sales_promotion".
 *
 * @property int $id
 * @property int $sn 编号
 * @property int $start_time 活动开始时间
 * @property int $end_time 活动结束时间
 * @property string $name 活动名称
 * @property string $intro 活动简介
 */
class SalesPromotion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sales_promotion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sn'], 'integer'],
            [['name', 'intro'], 'string', 'max' => 255],
            [['status','start_time','end_time'],'safe'],
            [['start_time'], 'requiredByASpecial'],
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
            'start_time' => '活动开始时间',
            'end_time' => '活动结束时间',
            'name' => '活动名称',
            'intro' => '活动简介',
            'status' => '状态'
        ];
    }

    //自定义验证
    public function requiredByASpecial($attribute, $end_time)

    {

        if ($this->start_time > $this->end_time)

        {

                $this->addError($attribute, "开始时间不能大于结束时间！");

        }

    }
}
