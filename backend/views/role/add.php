<?php
echo '<a href="'.\yii\helpers\Url::to(['role/index']).'" class="btn btn-info "><i class="glyphicon glyphicon-arrow-left"></i></a>';
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'description')->textarea();
echo $form->field($model,'permissions')->checkboxList($pers);
echo \yii\helpers\Html::submitButton('提交');
\yii\bootstrap\ActiveForm::end();