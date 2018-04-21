<?php
/**
 * Created by PhpStorm.
 * User: ASUS-F550L
 * Date: 2018/3/22
 * Time: 0:01
 */

namespace backend\controllers;


use backend\models\Goods;
use backend\models\SalesPromotion;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Request;

class SalesPromotionController extends Controller
{

    //展示促销活动
    public function actionIndex(){
        $query = SalesPromotion::find()->where(['is_display'=>1]);
        $countQuery = clone $query;
        $pages = new Pagination(['pageSize'=>5,'totalCount' => $countQuery->count()]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $goods = Goods::find()->where(['is_display'=>1])->asArray()->all();
//        $goods = ArrayHelper::map($goods,'sales_id','name');

        return $this->render('index',compact('model','pages','goods'));

    }

    //添加活动
    public function actionAdd(){
        $goods = Goods::find()->where(['is_display'=>1])->all();
        $goods = ArrayHelper::map($goods,'id','name');
        $array = [];
        $sales_ids = new Goods();
        $model = new SalesPromotion();
        $request = new Request();
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            $sales_ids ->load($request->post());
//            var_dump($model->logo);exit;
            //后台验证
            if ($model->validate()) {
                //将时间戳转数字
                $model->start_time = strtotime($model->start_time);
                $model->end_time = strtotime($model->end_time);
                $model->create_time = time();
                //保存数据
                if ($model->save()) {
                    $id = \Yii::$app->db->getLastInsertID();
                    foreach($sales_ids->sales_id as $k){
                        $good = Goods::findOne($k);
                        $good->sales_id = $id;
                        $good->save(false);
                    }

                    \Yii::$app->session->setFlash('success','添加成功');
                }else{
                    \Yii::$app->session->setFlash('danger','添加失败');
                }
            }
        }
        return $this->render('add',compact('model','sales_ids','goods','array'));
    }

    //编辑活动
    public function actionEdit($id){
        $defaults = Goods::find()->where(['is_display'=>1,'sales_id'=>$id])->all();
        $goods = Goods::find()->where(['is_display'=>1])->all();
        $goods = ArrayHelper::map($goods,'id','name');
        $array = ArrayHelper::map($defaults,'id','name');
//        var_dump($defaults);exit;
        $sales_ids = new Goods();
        $model = SalesPromotion::findOne($id);
        $request = new Request();
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            $sales_ids ->load($request->post());
//            var_dump($model->logo);exit;
            //后台验证
            if ($model->validate()) {
                //保存数据
                if ($model->save()) {
                    foreach($sales_ids as $k){
                        $good = Goods::findOne($k);
                        $goods->sales_id = $k;
                        $goods->save(false);
                    }

                    \Yii::$app->session->setFlash('success','添加成功');
                }else{
                    \Yii::$app->session->setFlash('danger','添加失败');
                }
            }
        }
        return $this->render('add',compact('model','sales_ids','goods','array'));
    }


    //删除活动
    public function actionDel($id){
        $sale = SalesPromotion::findOne($id);
        $sale->is_display = 0;
        if ($sale->save(false)) {
            \Yii::$app->session->setFlash('success','删除成功');
        }else{
            \Yii::$app->session->setFlash('danger','删除失败');
        }
        return $this->redirect(['sales-promotion/index']);
    }

}