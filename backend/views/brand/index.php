<?php
/* @var $this yii\web\View */
?>
<h1>品牌管理</h1>
<br>
<p>
    <a href="<?=yii\helpers\Url::to(['brand/add'])?>" class="btn btn-info">添加品牌</a>
</p>
<table class="table table-condensed table-bordered table-hover">
    <tr class="success">
        <th>编号</th>
        <th>名称</th>
        <th>简介</th>
        <th>头像</th>
        <th>排行</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php
        foreach($model as $row):
        if($row->is_display==1){
    ?>

            <tr>
            <td><?=$row->id?></td>
            <td><?=$row->name?></td>
            <td><?=$row->intro?></td>
            <td><img src="
            <?php
                echo strpos($row->logo,"ttp://")?$row->logo:"/".$row->logo;
                ?>" height="60"></td>

            <td><?=$row->sort?></td>
            <td><?php
                if($row->status){
                ?>
                    <i class="glyphicon glyphicon-ok" style="color: green"></i>
                    <?php
                }else{
                    ?>
                    <i class="glyphicon glyphicon-remove" style="color: red"></i>
                <?php
                }
                ?></td>
            <td><a href="<?=yii\helpers\Url::to(['brand/edit','id'=>$row->id])?>" class="btn btn-success"><i
                            class="glyphicon glyphicon-edit"></i></a>
            <a href="<?=yii\helpers\Url::to(['brand/del','id'=>$row->id])?>" class="btn btn-danger"><i
                        class="glyphicon glyphicon-trash"></i></a></td>
            </tr>

    <?php
        }
        endforeach;
    ?>

</table>
<div class="col col-md-offset-4">
    <?php
    echo  \yii\widgets\LinkPager::widget([
        'pagination' => $pages,
        'nextPageLabel' => '下一页',
        'prevPageLabel' => '上一页',
    ]);
    ?>
</div>
