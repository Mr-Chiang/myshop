<?php
echo '<a href="'.\yii\helpers\Url::to(['article/index']).'" class="btn btn-info "><i class="glyphicon glyphicon-arrow-left"></i></a>';
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'title');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'status')->inline()->radioList([1=>"激活",0=>"禁用"],['value'=>'1']);;
echo $form->field($model,'cate_id')->hiddenInput();
//$form->field($content, 'detail')->widget(\yii\redactor\widgets\Redactor::className(),[
//    'clientOptions' => [
//        'imageManagerJson' => ['/redactor/upload/image-json'],
//        'imageUpload' => ['/redactor/upload/image'],
//        'fileUpload' => ['/redactor/upload/file'],
//        'lang' => 'zh_cn',
//        'plugins' => ['clips', 'fontcolor','imagemanager']
//    ]
//]);
echo $form->field($content,'detail')->widget(\kucha\ueditor\UEditor::className(),[

    'clientOptions' => [
        //编辑区域大小
        'initialFrameHeight' => '200',
        //设置语言
        'lang' =>'zh-cn', //中文为 zh-cn
        ]
]);
//echo $form->field($content, 'detail')->textarea();
echo $form->field($model,'sort');
echo yii\helpers\Html::submitButton('确认添加',['class'=>'btn btn-success']);
yii\bootstrap\ActiveForm::end();