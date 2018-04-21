<?php
echo '<a href="'.\yii\helpers\Url::to(['sales-promotion/index']).'" class="btn btn-info "><i class="glyphicon glyphicon-arrow-left"></i></a>';
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'sn');
echo $form->field($model,'start_time')->widget(\kartik\datetime\DateTimePicker::className(), [
    'options' => ['placeholder' => '请选择活动开始时间'],
    'pluginOptions' => [
        'autoclose' => true,
        'startDate' =>date('Y-m-d'),
    ]
]);
echo $form->field($model,'end_time')->widget(\kartik\datetime\DateTimePicker::className(), [
    'options' => ['placeholder' => '请选择活动开始时间'],
    'pluginOptions' => [
        'autoclose' => true,
        'startDate' =>date('Y-m-d'),
    ]
]);

$arr = [];
foreach ($array as $k=>$v){
    $arr[] = $k;
}


echo $form->field($model,'intro')->textarea();
echo $form->field($model,'status')->inline()->radioList([1=>"进行中",0=>"结束"],['value'=>'1']);;
echo $form->field($sales_ids,'sales_id',
    [
        'inputOptions' => [
            'multiple' => 'multiple',
            'class' => 'form-control select-warp-option',
        ],

    ])->dropDownList($goods, ['prompt' => '请选择促销商品','value'=>$arr]);
echo yii\helpers\Html::submitButton('确认添加',['class'=>'btn btn-success']);
yii\bootstrap\ActiveForm::end();