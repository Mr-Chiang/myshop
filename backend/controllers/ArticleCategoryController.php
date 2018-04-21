<?php

namespace backend\controllers;

use backend\models\ArticleCategory;
use yii\web\Request;

class ArticleCategoryController extends VerifyController
{
    //列表展示文章分类
    public function actionIndex()
    {
        //获取所有数据
        $model = ArticleCategory::find()->orderBy('sort')->all();
        return $this->render('index',compact('model'));
    }

    //添加分类
    public function actionAdd(){
        //获取表单模型
        $model = new ArticleCategory();
        $request = new Request();
        //判断传值方式
        if ($request->isPost) {
            //绑定数据
            if ($model->load($request->post())) {
                //后台验证
                if ($model->validate()) {
                    //保存数据
                    if ($model->save()) {
                    //跳转到列表页
                        echo \Yii::$app->session->setFlash('success','添加分类成功');
                        return $this->redirect(['article-category/index']);
                    }else{
                        //跳转到列添加页
                        echo \Yii::$app->session->setFlash('danger','添加分类失败');
                        return $this->redirect(['article-category/add']);
                    }
                }
            }

        }
        //跳转到添加页
        return $this->render('add',compact('model'));
    }

    //修改分类
    public function actionEdit($id){
        //获取表单模型
        $model = ArticleCategory::findOne($id);
        $request = new Request();
        //判断传值方式
        if ($request->isPost) {
            //绑定数据
            if ($model->load($request->post())) {
                //后台验证
                if ($model->validate()) {
                    //保存数据
                    if ($model->save()) {
                        //跳转到列表页
                        echo \Yii::$app->session->setFlash('success','添加分类成功');
                        return $this->redirect(['article-category/index']);
                    }else{
                        //跳转到列添加页
                        echo \Yii::$app->session->setFlash('danger','添加分类失败');
                        return $this->redirect(['article-category/add']);
                    }
                }
            }

        }
        //跳转到添加页
        return $this->render('add',compact('model'));
    }

    //删除分类
    public function actionDel($id){
        $model = ArticleCategory::findOne($id);
        $model->is_display = 0;
        if ($model->save(false)) {
            echo \Yii::$app->session->setFlash('success','删除成功');
        }else{
            echo \Yii::$app->session->setFlash('danger','删除失败');
        }
        return $this->redirect(['article-category/index']);
    }

}
