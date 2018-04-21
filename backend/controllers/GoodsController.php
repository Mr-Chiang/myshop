<?php

namespace backend\controllers;

use backend\models\Brand;
use backend\models\Category;
use backend\models\Goods;
use backend\models\GoodsContent;
use backend\models\GoodsImages;
use function PHPSTORM_META\map;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Request;
use yii\web\UploadedFile;

class GoodsController extends VerifyController
{
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => "http://admin.shop.com"//图片访问路径前缀
//                    "imagePathFormat" => "http://p5oe8qg35.bkt.clouddn.com/", //上传保存路径

                ]
            ],
        ];
    }

    //展示商品列表
    public function actionIndex()
    {
        $key = isset($_GET['key'])?$_GET['key']:"";
        $minPrice = isset($_GET['minPrice'])?$_GET['minPrice']:0;
        $maxPrice = isset($_GET['maxPrice'])?$_GET['maxPrice']:9999999*99999;
        if($key ||$minPrice||$maxPrice ){
            $query = Goods::find()->Filterwhere(['and',
                ['is_display'=>1],
                ['>','price',$minPrice],
                ['<','price',$maxPrice],
                ['like','name',$key]])
                ->orFilterWhere(['and',
                ['is_display'=>1],
                ['>','price',$minPrice],
                ['<','price',$maxPrice],
                ['like','sn',$key]]);
        }else{
            $query = Goods::find()->where(['is_display'=>1]);
        }

        $countQuery = clone $query;
        $pages = new Pagination(['pageSize'=>5,'totalCount' => $countQuery->count()]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();



        return $this->render('index',compact('model','pages'));
    }

    //添加商品
    public function actionAdd(){
        $model = new Goods();
        $request = new Request();
        $content = new GoodsContent();
        $goodsImages = new GoodsImages();
        $categorys = Category::find()->where(['=','is_display',1])->orderBy('tree,left')->all();
        $categorys = ArrayHelper::map($categorys,'id','nameText');

        //构造编号
        $count = Goods::find()->select(['sn'])->orderBy(['sn'=>SORT_DESC])->limit(1,0)->asArray()->all();
        if($count){
            $count = $count[0]['sn']+1;
        }else {

            //初始化一个值
            $count = date('Ymd', time());
                $count = $count*10*10*10*10;
            $count = $count+1;
        }

//        var_dump($count);exit;
        $brand = Brand::find()->asArray()->all();
        $brand = ArrayHelper::map($brand,'id','name');

        //判断传值方式
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            $content->load($request->post());
            $goodsImages->load($request->post());
            //后台验证
            if ($model->validate() && $content->validate()) {
                $model->create_time = time();
                $model->update_time = time();
                //保存数据
                if ($model->save()) {
                    $content->goods_id = \Yii::$app->db->getLastInsertID();
                    if ($content->save()) {
                        foreach ($goodsImages->images as $k){
//                            var_dump($k);exit;
                            $goodsImg = new GoodsImages();
                            $goodsImg->goods_id = $content->goods_id;
                            $goodsImg->path = $k;
                            //保存数据
                            $goodsImg->save();
                        }


                        \Yii::$app->session->setFlash('success','添加成功');
                        return $this->refresh();
                    }
                }
                \Yii::$app->session->setFlash('danger','添加失败');
            }else{
                \Yii::$app->session->setFlash('danger','添加失败');
            }

        }
        return $this->render('add',compact('model','content','brand','count','goodsImages','categorys'));
    }

    //编辑商品
    public function actionEdit($id){
        $model = Goods::findOne($id);
        $goodsImages = new GoodsImages();
        $goods = GoodsImages::find()->where(['goods_id'=>$id])->all();
        $goodsImages->images = ArrayHelper::map($goods,'id','path');
//        var_dump($goodsImages);exit;
        $request = new Request();
        $categorys = Category::find()->where(['=','is_display',1])->orderBy('tree,left')->all();
        $categorys = ArrayHelper::map($categorys,'id','nameText');
        $content = GoodsContent::findOne(['goods_id'=>$id]);
        $count = $model->sn;
        //构造编号
        $sn = Goods::find()->select(['sn'])->orderBy(['sn'=>SORT_DESC])->limit(1,0)->asArray()->all();
        if(intval($count) != intval($sn[0]['sn'])){
            $sn = $sn[0]['sn']+1;
        }
        $brand = Brand::find()->asArray()->all();
        $brand = ArrayHelper::map($brand,'id','name');

        //判断传值方式
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            $content->load($request->post());
            $goodsImages->load($request->post());
            //后台验证
            if ($model->validate() && $content->validate()) {
                $model->update_time = time();
                //保存数据
                if ($model->save()) {
                    if ($content->save()) {
                        GoodsImages::deleteAll(['goods_id'=>$id]);
                        foreach ($goodsImages->images as $k){
//                            var_dump($k);exit;
                            $goodsImg = new GoodsImages();
                            $goodsImg->goods_id = $id;
                            $goodsImg->path = $k;
                            //保存数据
                            $goodsImg->save();
                        }

                        \Yii::$app->session->setFlash('success','修改成功');
                        return $this->redirect(['goods/index']);
                    }
                }
                \Yii::$app->session->setFlash('danger','修改失败');
            }else{
                \Yii::$app->session->setFlash('danger','修改失败');
            }

        }
        return $this->render('add',compact('model','content','brand','count','categorys','goodsImages'),$sn);
    }

    //删除商品
    public function actionDel($id){
        $model = Goods::findOne($id);
        $goodsImg = GoodsContent::findOne(['goods_id'=>$id]);
        $model->is_display = 0;
        $goodsImg->is_display = 0;
        //保存数据
        if ($model->save(false) && $goodsImg->save(false)) {
            \Yii::$app->session->setFlash('success','删除成功');
        }else{
            \Yii::$app->session->setFlash('fanger','删除失败');
        }
        return $this->redirect(['goods/index']);
    }


    public function actionUpload(){
        //得到文件上传对象
        $fileObject = UploadedFile::getInstanceByName("file");
        //移动到临时目录
        if($fileObject!==null){
            //拼路径
            $filePath = "images/".time().".".$fileObject->extension;
            if($fileObject->saveAs($filePath,false)){
                // 正确时， 其中 attachment 指的是保存在数据库中的路径，url 是该图片在web可访问的地址
//            {"code": 0, "url": "http://domain/图片地址", "attachment": "图片地址"}
                $load = [
                    "code" => "0",
                    "url" => "/".$filePath,
                    "attachment" => $filePath

                ];
                return json_encode($load);
            }else{
                // 错误时
                //{"code": 1, "msg": "error"}
                $load = [
                    "code" => 1,
                    "msg" => "error"
                ];
                return json_encode($load);
            }
        }

    }


}
