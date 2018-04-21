<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleContent;

class ArticleContentController extends VerifyController
{
    public function actionIndex($id)
    {
        $model = Article::findOne($id);
        $content = ArticleContent::findOne(['article_id'=>$id]);
        return $this->render('index',compact('model','content'));
    }

}
