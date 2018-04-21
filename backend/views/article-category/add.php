<?php
echo '<a href="'.\yii\helpers\Url::to(['article-category/index']).'" class="btn btn-info "><i class="glyphicon glyphicon-arrow-left"></i></a>';

$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'status')->inline()->radioList([1=>"激活",0=>"禁用"],['value'=>'1']);;
echo $form->field($model,'is_help')->inline()->radioList([1=>"是",0=>"否"],['value'=>'0']);
echo $form->field($model,'sort');
echo yii\helpers\Html::submitButton('确认添加',['class'=>'btn btn-success']);
yii\bootstrap\ActiveForm::end();