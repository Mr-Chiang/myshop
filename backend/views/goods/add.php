<?php
/* @var $this yii\web\View */
//var_dump($count);exit;
if(isset($sn)){
    $count = $sn;
}
echo '<a href="'.\yii\helpers\Url::to(['goods/index']).'" class="btn btn-info "><i class="glyphicon glyphicon-arrow-left"></i></a>';
$form = yii\bootstrap\ActiveForm::begin();
echo $form->field($model,"name");
echo $form->field($model,"sn")->textInput(['value'=>$count]);
echo '<a href="javascripts:void(0)" class="btn btn-info" id="auto">系统生成编号</a>';
$count=isset($sn)?$sn:$count;
echo $form->field($model,"intro")->textarea();
echo $form->field($model,"market_price");
echo $form->field($model,"price");
echo $form->field($model,"category_id")->dropDownList($categorys,['prompt'=>'请选择分类']);
echo $form->field($model,"brand_id")->dropDownList($brand,['prompt'=>'请选择品牌']);
echo $form->field($model, 'logo')->widget(\manks\FileInput::className(), [
]);

echo $form->field($goodsImages, 'images')->widget(\manks\FileInput::className(),
    [
        'clientOptions' => [
            'pick' => [
                'multiple' => true,
            ],
        ],

]);

echo $form->field($model,"sort");
echo $form->field($model,"status")->inline()->radioList([1=>"在售",0=>"未上线"],['value'=>1]);
echo $form->field($content,'content')->widget(\kucha\ueditor\UEditor::className(),[

    'clientOptions' => [
        //编辑区域大小
        'initialFrameHeight' => '200',
        //设置语言
        'lang' =>'zh-cn', //中文为 zh-cn
    ]
]);
echo yii\helpers\Html::submitButton("提交",["class"=>"btn btn-success"]);
yii\bootstrap\ActiveForm::end();

$js = <<<JS
       $('#auto').click(function(k,v) {  
               $('#goods-sn').val($count);   
       });
JS;
$this->registerJs($js);

?>

