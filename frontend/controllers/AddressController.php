<?php

namespace frontend\controllers;

use frontend\models\Address;
use yii\helpers\Json;

class AddressController extends \yii\web\Controller
{
    public $enableCsrfValidation=false;
    public function actionIndex()
    {
        $data = Address::find()->where(['user_id'=>\Yii::$app->user->id])->orderBy(['status'=>SORT_DESC])->all();
        return $this->render('index',compact('data'));
    }

    /**
     * 添加收货地址
     */
    public function actionAdd(){

        //Post传值
        $request = \Yii::$app->request;
        $model = new Address();
        if($model->load($request->post())){
//            return $model->status;
            //验证
            if($model->validate()){
                $model->user_id = \Yii::$app->user->getId();
                //保存数据
                if($model->status!=null){
                    $addressOne = Address::findOne(['user_id'=>\Yii::$app->user->getId(),'status'=>1]);
                    if($addressOne){
                        $addressOne->status = 0;
                        $addressOne->save();
                    }
                    $model->status = 1;
                }
                $model->save();
                $res = [
                    'status' =>1,
                    'data' =>'添加成功',
                ];
                return Json::encode($res);
            }else{
                //返回错误信息
                 $res = [
                    'status' =>0,
                    'data' =>$model->errors,
                ];
                 return Json::encode($res);
            }
        }

    }


    /**
     * 删除地址
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDel($id){
        $model = Address::findOne(['id'=>$id,'user_id'=>\Yii::$app->user->getId()]);
        if ($model->delete()) {
            \Yii::$app->session->setFlash('success','删除成功');
        }else{
            \Yii::$app->session->setFlash('danger','删除失败');
        }
        return $this->redirect('/address/index');
    }

    public function actionDefault($id){
        $model = Address::findOne(['id'=>$id,'user_id'=>\Yii::$app->user->getId()]);
        $addressOne = Address::findOne(['status'=>1,'user_id'=>\Yii::$app->user->getId()]);
        $model->status = 1;
        if($addressOne){
            $addressOne->status = 0;
            $addressOne->save();
        }
        $model->save();
        return $this->redirect('/address/index');
    }

}
