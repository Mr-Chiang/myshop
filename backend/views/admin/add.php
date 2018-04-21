<?php
echo '<a href="'.\yii\helpers\Url::to(['admin/index']).'" class="btn btn-info "><i class="glyphicon glyphicon-arrow-left"></i></a>';
$form = yii\bootstrap\ActiveForm::begin();
echo $form->field($model,"name");
echo $form->field($model,"password")->passwordInput(['value'=>""]);
echo $form->field($model,"status")->inline()->radioList([1=>'激活',0=>'禁用']);
echo $form->field($model,'roles')->checkboxList($roles,['multiple'=>'multiple']);
echo $form->field($model,"intro")->textarea();
//echo $form->field($model,"imgFile")->fileInput();
// ActiveForm
echo $form->field($model, 'logo')->widget(\manks\FileInput::className(), [
]);
echo yii\helpers\Html::submitButton("提交",["class"=>"btn btn-success"]);
yii\bootstrap\ActiveForm::end();