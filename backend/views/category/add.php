<?php
echo '<a href="'.\yii\helpers\Url::to(['category/index']).'" class="btn btn-info "><i class="glyphicon glyphicon-arrow-left"></i></a>';
$form = yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'parent_id');
echo \liyuze\ztree\ZTree::widget([
    'setting' => '{
          view: {
                  selectedMulti: false, //设置是否能够同时选中多个节点
                  showIcon: true, //设置是否显示节点图标
                  showLine: true, //设置是否显示节点与节点之间的连线
                  showTitle: false, //设置是否显示节点的title提示信息
                  expandAll:true,
                  },
           check:{
                  enable: false  //设置是否显示checkbox复选框
                  },
			data: {
				simpleData: {
					enable: true,
					pIdKey: "parent_id",
				}
			},
			callback:{
			  onClick:onClick
			}
			
		}',

    'nodes' => $data
]);
echo yii\helpers\Html::submitButton('提交',['class'=>'btn btn-success']);
yii\bootstrap\ActiveForm::end();
$js = <<<JS
//得到所有节点
 var treeObj = $.fn.zTree.getZTreeObj("w1");
//展开所有节点
 treeObj.expandAll(true);
 //得到对应子节点
var node = treeObj.getNodeByParam("id", "$model->parent_id", null);
//选中节点
treeObj.selectNode(node);
JS;
//注册js
$this->registerJs($js);
?>

<script>
    function onClick(e,treeId, treeNode) {
        var val=$('#category-parent_id').val($(treeNode).prop('id'));
    }
</script>



