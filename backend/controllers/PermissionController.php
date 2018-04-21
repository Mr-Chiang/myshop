<?php

namespace backend\controllers;

use backend\models\AuthItem;
use yii\web\Request;

class PermissionController extends \yii\web\Controller
{
    /**权限列表
     * @return string
     */
    public function actionIndex()
    {
        //创建auth对象
        $auth = \Yii::$app->authManager;
        //获取所有权限
        $pers = $auth->getPermissions();

        return $this->render('index',compact('pers'));
    }

    /**
     * 权限添加
     * @return string|\yii\web\Response
     */
    public function actionAdd(){
        //创建模型对象
        $model = new AuthItem();
        $request = new Request();
        if($model->load($request->post()) && $model->validate()){
            //创建auth对象
            $auth = \Yii::$app->authManager;
            //创建权限
            $per = $auth->createPermission($model->name);
            //设置描述
            $per->description = $model->description;
//        权限入库
            if ($auth->add($per)) {
                \Yii::$app->session->setFlash('success','权限添加成功');

            }else{
                \Yii::$app->session->setFlash('danger','权限添加失败');
            }
            return $this->refresh();

        }
        //显示视图
        return $this->render('add',compact("model"));

    }

    /**
     * 编辑权限
     * @param $name 权限名称
     * @return string|\yii\web\Response
     */
    public function actionEdit($name){
        //创建模型对象
        $model = AuthItem::findOne($name);
        $request = new Request();
        if($model->load($request->post()) && $model->validate()){
            //创建auth对象
            $auth = \Yii::$app->authManager;
            //得到权限
            $per = $auth->getPermission($model->name);
            //设置描述
            $per->description = $model->description;
//        权限入库
            if ($auth->update($model->name,$per)) {
                \Yii::$app->session->setFlash('success','权限修改成功');

            }else{
                \Yii::$app->session->setFlash('danger','权限修改失败');
            }
            return $this->refresh();

        }
        //显示视图
        return $this->render('edit',compact("model"));

    }

    /**
     * 删除权限
     * @param $name 权限名称
     */
    public function actionDel($name){
//        var_dump($name);exit;
        //创建auth对象
        $auth = \Yii::$app->authManager;
        //找到权限
        $per = $auth->getPermission($name);
//        var_dump($per);exit;
        //删除权限
        if ($auth->remove($per)) {
            \Yii::$app->session->setFlash('success','删除权限成功');
        }else{
            \Yii::$app->session->setFlash('danger','删除权限失败');
        }
        return $this->refresh();

    }
}
