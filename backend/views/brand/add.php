<?php
echo '<a href="'.\yii\helpers\Url::to(['brand/index']).'" class="btn btn-info "><i class="glyphicon glyphicon-arrow-left"></i></a>';
$form = yii\bootstrap\ActiveForm::begin();
echo $form->field($model,"name");
echo $form->field($model,"intro")->textarea();
//echo $form->field($model,"imgFile")->fileInput();
// ActiveForm
echo $form->field($model, 'logo')->widget(\manks\FileInput::className(), [
]);
echo $form->field($model,"sort");
echo $form->field($model,"status")->inline()->radioList([1=>"激活",0=>"未激活"]);
echo $form->field($model,"code")->widget(yii\captcha\Captcha::className(),[
    'captchaAction' => "brand/code",
    'template' => '<div class="row"><div class="col col-lg-1">{input}</div><div class="col col-lg-1">{image}</div></div>',

]);
echo yii\helpers\Html::submitButton("提交",["class"=>"btn btn-success"]);
yii\bootstrap\ActiveForm::end();