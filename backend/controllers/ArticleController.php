<?php

namespace backend\controllers;

use backend\filters\LoginFilter;
use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleContent;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\web\UploadedFile;

class ArticleController extends VerifyController
{
public function behaviors()
{
   return  [
        'Verification' =>[
            'class' => LoginFilter::className(),
        ]

    ];
//       return $this->redirect(['/site/login']);
}

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
//                    "imageUrlPrefix"  => "/images/",//图片访问路径前缀
//                    "imagePathFormat" => "", //上传保存路径
//                    "imageRoot" => \Yii::getAlias("@webroot")
                ]
            ],
        ];
    }
    //展示所有文章的方法
    public function actionIndex()
    {
        //获取所有数据模型
        $query = Article::find()->where('is_display=1')->orderBy('sort');

        $countQuery = clone $query;
        $pages = new Pagination(['pageSize'=>5,'totalCount' => $countQuery->count()]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index', [
            'model' => $model,
            'pages' => $pages,
        ]);
    }

    //添加文章
    public function actionAdd(){
        //文章模型
        $model = new Article();
        $request = new Request();
        //文章内容模型
        $content = new ArticleContent();
        //分类数据
        $category = ArticleCategory::find()->where(['is_display'=>1])->all();
        $category = ArrayHelper::map($category,'id','name');
        //判断传值方式
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            $content->load($request->post());
//            var_dump($content);exit;
            //后台验证数据
            if($model->validate() && $content->validate()){
                $model->create_time = time();
                $model->update_time = time();
                //保存数据
                $model->save();
                //得到id
                $content->article_id = \Yii::$app->db->getLastInsertID();
                //保存数据
                $content->save();
                //跳转视图
                echo \Yii::$app->session->setFlash('success','添加文章成功');
                return $this->redirect(['article/index']);
            }else{
                //跳转视图
                echo \Yii::$app->session->setFlash('danger','添加文章失败');
                return $this->redirect(['article/add']);
            }
        }
        //呈现添加视图
        return $this->render('add',compact('model','category','content'));
    }

    //修改文章
    public function actionEdit($id){
        //文章模型
        $model = Article::findOne($id);
        $request = new Request();
        //文章内容模型
        $content = ArticleContent::findOne(['article_id'=>$id]);
        //分类数据
        $category = ArticleCategory::find()->where(['is_display'=>1])->all();
        $category = ArrayHelper::map($category,'id','name');
        //判断传值方式
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            $content->load($request->post());
            //后台验证数据
            if($model->validate() && $content->validate()){
                $model->update_time = time();
                //保存数据
                if ($model->save(false) && $content->save(false)) {

                //跳转视图
                echo \Yii::$app->session->setFlash('success','添加文章成功');
                return $this->redirect(['article/index']);
                }
            }
                //跳转视图
                echo \Yii::$app->session->setFlash('danger','添加文章失败');
                return $this->redirect(['article/add']);
        }
        //呈现添加视图
        return $this->render('add',compact('model','category','content'));
    }

    //删除文章
    public function actionDel($id){
        $model = Article::findOne($id);
        $content = ArticleContent::findOne(['article_id'=>$id]);
        $model->is_display = 0;
        $content->is_display = 0;
        //删除数据
        if($model->save() && $content->save()){
            echo \Yii::$app->session->setFlash('success','删除数据成功');
        }else{
            echo \Yii::$app->session->setFlash('success','删除数据成功');
        }
        return $this->redirect(['article/index']);
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
