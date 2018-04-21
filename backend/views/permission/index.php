<?php
/* @var $this yii\web\View */
?>
<h1>权限管理</h1>
<br>
<p>
    <a href="<?=yii\helpers\Url::to(['permission/add'])?>" class="btn btn-info">添加权限</a>
</p>
<table class="table table-condensed table-bordered table-hover">
    <tr class="success">
        <th>名称</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php
        foreach($pers as $row):
    ?>

            <tr>
            <td><?php
                echo strpos($row->name,'/')!==false?"----".$row->name:"".$row->name
                ?></td>
            <td><?=$row->description?></td>
            <td><a href="<?=yii\helpers\Url::to(['permission/edit','name'=>$row->name])?>" class="btn btn-success"><i
                            class="glyphicon glyphicon-edit"></i></a>
            <a href="<?=yii\helpers\Url::to(['permission/del','name'=>$row->name])?>" class="btn btn-danger"><i
                        class="glyphicon glyphicon-trash"></i></a></td>
            </tr>

    <?php
        endforeach;
    ?>

</table>
<div class="col col-md-offset-4">
<!--    --><?php
//    echo  \yii\widgets\LinkPager::widget([
//        'pagination' => $pages,
//        'nextPageLabel' => '下一页',
//        'prevPageLabel' => '上一页',
//    ]);
//    ?>
</div>
