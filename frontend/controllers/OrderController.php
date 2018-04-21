<?php

namespace frontend\controllers;

class OrderController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //获取订单信息
        return $this->render('index');
    }


}
