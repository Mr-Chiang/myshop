<?php
/**
 * Created by PhpStorm.
 * User: ASUS-F550L
 * Date: 2018/3/15
 * Time: 20:02
 */

namespace backend\controllers;


use backend\models\Brand;
use yii\captcha\Captcha;
use yii\captcha\CaptchaAction;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;
use crazyfd\qiniu\Qiniu;

class BrandController extends VerifyController
{
    //验证码
    public function actions()
    {
        return [
            'code' => [
                'class' =>CaptchaAction::className(),
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength' => 3, //最大长度
                'minLength' => 3 //最小长度
            ],
        ];
    }
    //展示列表
    public function actionIndex(){
        $query = Brand::find();
        $countQuery = clone $query;
        $pages = new Pagination(['pageSize'=>5,'totalCount' => $countQuery->count()]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render("index",compact('model','pages'));
    }

    //添加品牌
    public function actionAdd1(){
        $model = new Brand();
        $request = new Request();
        //判断传值方式
        if($request->isPost){
            //绑定数据
            $model->load($request->post());
            //得到文件上传对象
            $model->imgFile = UploadedFile::getInstance($model,"imgFile");
            //构建路劲
            $imgPath = "";
            if($model->imgFile){
                $imgPath = "images/".time().".".$model->imgFile->extension;
                //后台验证
                if ($model->validate(false)) {
                    //移动文件
                    $model->imgFile->saveAs($imgPath,false);
                    $model->logo = $imgPath;
                    //保存数据
                    $model->save();
                    echo \Yii::$app->session->setFlash("success","添加成功");
                    return $this->redirect(["brand/index"]);
                }else{
                    echo \Yii::$app->session->setFlash("danger","添加失败");
                    return $this->redirect(["brand/add"]);
                }
            }

        }

        //跳转到添加页面
        return $this->render("add",compact("model"));

    }

    //编辑品牌
    public function actionEdit($id){
        $model = Brand::findOne($id);
        $request = new Request();
        //判断传值方式
        if($request->isPost) {
            //绑定数据
            $model->load($request->post());
            //得到文件上传对象
            $model->imgFile = UploadedFile::getInstance($model, "imgFile");
            //构建路劲
            $imgPath = "";
            if ($model->imgFile) {

                $imgPath = "images/" . time() . "." . $model->imgFile->extension;
                //后台验证
                if ($model->validate()) {
                    var_dump($model);exit;
                    //移动文件
                    $model->imgFile->saveAs($imgPath, false);
                    $model->logo = $imgPath;
                    //保存数据
                    if ($model->save(false)) {
                        echo \Yii::$app->session->setFlash("success", "修改成功");
                        return $this->redirect(["brand/index"]);
                    }
                }
                echo \Yii::$app->session->setFlash("danger", "修改失败");

            }else{
                if ($model->save(false)) {
                    echo \Yii::$app->session->setFlash("success", "修改成功");
                    return $this->redirect(["brand/index"]);
                }
            }
        }
        //跳转到修改页面
        return $this->render("add",compact("model"));

    }

    //删除品牌
    public function actionDel($id){
        $model = Brand::findOne($id);
        $model->is_display = 0;

        //var_dump($model->save());exit;
        if ($model->save(false)){
            \Yii::$app->session->setFlash("success","删除成功");
        }else{
            \Yii::$app->session->setFlash("danger","删除失败");
        }
        return $this->redirect(["brand/index"]);
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

    //添加品牌
    public function actionAdd()
    {
        $model = new Brand();
        $request = new Request();
        //判断传值方式
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            //构建路劲
            //后台验证
            if ($model->validate(false)) {
                    //保存数据
                    $model->save(false);
                    echo \Yii::$app->session->setFlash("success", "添加成功");
                    return $this->redirect(["brand/index"]);
                } else {
                    echo \Yii::$app->session->setFlash("danger", "添加失败");
                    return $this->redirect(["brand/add"]);
                }
        }
            //跳转到添加页面
            return $this->render("add", compact("model"));
    }


    public function actionQiniuUpload(){
            $ak = 'QVb3tGS3o9OTSYaAOAcXCqyYJnsEn5D_geIr8q6j';
            $sk = 'CCHgGoMk9YCOwKtV1GU6bOPoJv7VehiNcmHqy3AE';
            $domain = 'http://p5oe8qg35.bkt.clouddn.com';
            $bucket = 'chiang';
            $zone = 'south_china';
            //获取七牛云对象
            $qiniu = new Qiniu($ak, $sk,$domain, $bucket,$zone);
            //构建路劲
            $key = time();
            $key .= strtolower(strrchr($_FILES['file']['name'], '.'));
            $qiniu->uploadFile($_FILES['file']['tmp_name'],$key);
            $url = $qiniu->getLink($key);

        //得到文件上传对象
        $fileObject = UploadedFile::getInstanceByName("file");
                // 正确时， 其中 attachment 指的是保存在数据库中的路径，url 是该图片在web可访问的地址
//            {"code": 0, "url": "http://domain/图片地址", "attachment": "图片地址"}
                $load = [
                    "code" => "0",
                    "url" => $url,
                    "attachment" => $url

                ];
                return json_encode($load);

            }


}