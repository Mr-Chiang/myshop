<?php
/**
 * Created by PhpStorm.
 * User: ASUS-F550L
 * Date: 2018/3/20
 * Time: 14:28
 */

namespace backend\controllers;


use backend\models\Goods;
use backend\models\GoodsContent;
use backend\models\GoodsImages;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class GoodsContentController extends VerifyController
{
       public function actionIndex($id){
           $model = GoodsContent::findOne($id);
           $good = Goods::findOne($id);
           $images = GoodsImages::find()->where(['goods_id'=>$id])->all();
           $images = ArrayHelper::map($images,'id','path');
           return $this->render('index',compact('model','good','images'));
       }
}