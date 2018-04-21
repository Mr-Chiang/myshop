<?php
/**
 * Created by PhpStorm.
 * User: ASUS-F550L
 * Date: 2018/3/28
 * Time: 18:30
 */

namespace frontend\controllers;


use backend\models\Category;
use backend\models\Goods;
use yii\web\Controller;

class IndexController extends Controller
{
    public $defaultAction = 'index';

    /**
     * 主页
     * @return string
     */
    public function actionIndex(){
        $categorys = Category::find()->where(['is_display'=>1])->all();
        return $this->render('index',compact('categorys'));
    }

    /**
     * 商品列表
     * @param $id 分类id
     * @return string
     */
    public function actionList($id){
        //通过分类id找到所有分类
        $cate = Category::findOne($id);
        $cates = Category::find()->where(['is_display'=>1,'tree'=>$cate->tree])
            ->andWhere(['>=','left',$cate->left])
            ->andWhere(['<=','right',$cate->right])->asArray()->all();
        $cates = array_column($cates,'id');

        //找到分类下所有商品
        $goods = Goods::find()->where(['is_display'=>1])->andWhere(['in','category_id',$cates])->all();
//        var_dump($goods);exit;
        return $this->render('list',compact('goods'));
    }
}