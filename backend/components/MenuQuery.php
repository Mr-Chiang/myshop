<?php
/**
 * Created by PhpStorm.
 * User: ASUS-F550L
 * Date: 2018/3/18
 * Time: 13:58
 */

namespace backend\components;


use creocoder\nestedsets\NestedSetsQueryBehavior;
use yii\db\ActiveQuery;

class MenuQuery extends ActiveQuery
{
	//hhhhhhhh

    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}