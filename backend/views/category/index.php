<?php
/* @var $this yii\web\View */
?>
<h1>商品分类展示</h1>
    <br>
<p>
    <a href="<?=yii\helpers\Url::to(['category/add'])?>" class="btn btn-info">添加分类</a>
</p>
<table class="table table-bordered table-hover">
    <tr class="success">
        <th>商品id</th>
        <th>商品名称</th>
        <th>商品简介</th>
        <th>父类ID</th>
        <th>操作</th>
    </tr>
    <?php
    foreach ($model as $row):
        if($row->is_display) {
            ?>
            <tr display="block">
                <td><?= $row->id ?></td>
                <td class="cate" left="<?=$row->left?>" right="<?=$row->right?>" tree="<?=$row->tree?>">
                    <?php
                    echo str_repeat('&nbsp;',$row->depth*5).'<i class="glyphicon glyphicon-chevron-down"></i>'.$row->name;
                    ?></td>
                <td><?= $row->intro ?></td>
                <td><?= $row->parent_id?></td>
                <td>
                    <a href="<?= \yii\helpers\Url::to(['/category/edit', 'id' => $row->id]) ?>"><i
                                class="glyphicon glyphicon-edit btn btn-success"></i></a>
                    <a href="<?= \yii\helpers\Url::to(['/category/del', 'id' => $row->id]) ?>"><i
                                class="glyphicon glyphicon-trash btn btn-danger"></i></a>
                 </td>
            </tr>
            <?php
        }
    endforeach;

    ?>
</table>
<?php


$js = <<<JS
     $('.cate').click(function() {
         var a = $(this).children('i').attr('class');
         $(this).children('i').attr('class')=='glyphicon glyphicon-chevron-right'?$(this).children().attr('class','glyphicon glyphicon-chevron-down'):$(this).children().attr('class','glyphicon glyphicon-chevron-right');
             var treeParent = $(this).attr('tree');
             var leftParent = $(this).attr('left');
             var rightParent = $(this).attr('right');
             var a = $(this);
             $('.cate').each(function(k,v) {
                    var tree = $(v).attr('tree');
                    var left = $(v).attr('left')-0;
                    var right = $(v).attr('right')-0;
           
                    if(tree===treeParent && left>leftParent && right<rightParent){
                        console.dir($(v).children('i').attr('class'));
                        console.dir($(a).children('i').attr('class'));
                    
                        if($(a).children('i').attr('class')=='glyphicon glyphicon-chevron-right' ){
                              // v.children();
                              if(!$(v).parent('tr').is(":hidden")){
                                  $(v).children('i').attr('class','glyphicon glyphicon-chevron-right');
                                  $(v).parent('tr').hide();
                             }
                        }else {
                            if($(v).parent('tr').is(":hidden")){
                                $(v).children('i').attr('class','glyphicon glyphicon-chevron-down');
                                  $(v).parent('tr').show();
                        }
                        }
                    }
             });

     });


JS;
$this->registerJs($js);
?>