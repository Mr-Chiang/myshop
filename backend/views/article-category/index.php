<?php
/* @var $this yii\web\View */
?>
<h1>文字分类管理</h1>

<p>
    <a href="<?=\yii\helpers\Url::to(['/article-category/add'])?>" class="btn btn-info">添加分类</a>
</p>
<table class="table table-bordered table-hover" >
    <tr class="success" >
        <th>分类名称</th>
        <th>分类简介</th>
        <th>状态</th>
        <th>排序</th>
        <th>是否帮助类</th>
        <th>操作</th>
    </tr>
    <?php
        foreach ($model as $row):
            if($row->is_display) {
                ?>
                <tr>
                    <th><?= $row->name ?></th>
                    <th><?= $row->intro ?></th>
                    <th><?php
                        echo $row->status ? '激活' : '未激活';
                        ?></th>
                    <th><?= $row->sort ?></th>
                    <th><?php
                        echo $row->is_help ? '是' : '否';
                        ?></th>
                    <th>
                        <a href="<?= \yii\helpers\Url::to(['/article-category/edit', 'id' => $row->id]) ?>"><i
                                    class="glyphicon glyphicon-edit btn btn-success"></i></a>
                        <a href="<?= \yii\helpers\Url::to(['/article-category/del', 'id' => $row->id]) ?>"><i
                                    class="glyphicon glyphicon-trash btn btn-danger"></i></a>
                    </th>
                </tr>
                <?php
            }
       endforeach;
    ?>
</table>
