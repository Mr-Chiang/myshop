<?php

namespace backend\controllers;

use backend\models\Category;
use yii\base\ErrorException;
use yii\data\Pagination;
use yii\db\Exception;
use yii\web\Request;

class CategoryController extends VerifyController
{

    //展示商品
    public function actionIndex()
    {

        $model = Category::find()->where('is_display=1')->orderBy(['tree'=>SORT_ASC,'left'=>SORT_ASC])->all();
        return $this->render('index', [
            'model' => $model,
        ]);

    }

    //添加商品
    public function actionAdd(){
        $request = new Request();
        $model = new Category();
        $data = Category::find()->where(['>','is_display','0'])->asArray()->all();
        $data[] = ['id'=>0,'name'=>'一级分类','parent_id'=>0];
        $data = json_encode($data);
//        var_dump($data);exit;
        //判断传值方式
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            //后台验证
            if ($model->validate()) {
                if(!$model->parent_id){
                    //一级分类
                    $model->makeRoot();
                    //保存数据
                    if ($model->save()) {
                        \Yii::$app->session->setFlash('success','添加成功');
                        return $this->refresh();
                    }
                }else{
                    //多级分类
                    $russia =Category::findOne($model->parent_id);
                    $model->prependTo($russia);
                    if ($model->save()) {
                        \Yii::$app->session->setFlash('success','添加成功');
                        return $this->refresh();
                    }

                }
            }
            \Yii::$app->session->setFlash('danger','添加失败');
        }
        return $this->render('add',compact('model','data'));
    }

    //编辑商品
    public function actionEdit($id)
    {
        $request = new Request();
        $model = Category::findOne($id);
        $data = Category::find()->asArray()->all();
        $data[] = ['id' => 0, 'name' => '一级分类', 'parent_id' => 0];
        $data = json_encode($data);
        //判断传值方式
        if ($request->isPost) {
            $parent = $model->parent_id;
            //绑定数据
            $model->load($request->post());
            //后台验证
            if ($model->validate()) {

                try {


                    if (!$model->parent_id) {
                        //一级分类
                        //保存数据
                        \Yii::$app->session->setFlash('success', '添加成功');
                        return $this->refresh();
                    } else {
                        //多级分类
                        $russia = Category::findOne($model->parent_id);
                        $model->prependTo($russia);
                        \Yii::$app->session->setFlash('success', '添加成功');
                        return $this->redirect(['category/index']);
                    }

                    \Yii::$app->session->setFlash('danger', '添加失败');
                } catch (Exception $exception) {
                    \Yii::$app->session->setFlash('danger', '不能将父类移动到子类下');
                }

            }
        }
        return $this->render('add',compact('model','data'));
    }

    //删除商品
    public function actionDel($id){
        $model = Category::findOne($id);
        $models = Category::find()->where(["AND",
                ['>','left',$model->left],
                ['=','tree',$model->tree],
                ['<','right',$model->right],
                ['=','is_display',1]

        ])->all();
//        var_dump($models);exit;
        if(!$models){
            $model->is_display = 0;
            //保存数据
            if ($model->save(false)) {
                \Yii::$app->session->setFlash('success','删除成功');
            }else{
                \Yii::$app->session->setFlash('danger','删除失败');
            }
        }else{
            \Yii::$app->session->setFlash('danger','当前分类下有子分类，不能被删除');
        }

        return $this->redirect(['category/index']);
    }

}
