<?php
/* @var $this yii\web\View */
?>
<h1>文章列表</h1>
<br>
<p>
    <a href="<?=yii\helpers\Url::to(['article/add'])?>" class="btn btn-info">添加文章</a>
</p>
<table class="table table-bordered table-hover">
    <tr class="success">
        <th>文章标题</th>
        <th>文章简介</th>
        <th>文章排序</th>
        <th>文章状态</th>
        <th>文章分类</th>
        <th>创建时间</th>
        <th>修改时间</th>
        <th>操作</th>
    </tr>
    <?php
        foreach ($model as $row):
            if($row->is_display) {
                ?>
                <tr>
                    <td><?= $row->title ?></td>
                    <td><?= $row->intro ?></td>
                    <td><?= $row->sort ?></td>
                    <td><?php
                        echo $row->status?'上线':'禁用';
                        ?></td>
                    <td><?= $row->cate_id ?></td>
                    <td><?= date('Y-m-d H:i:s',$row->create_time) ?></td>
                    <td><?= date('Y-m-d H:i:s',$row->update_time) ?></td>
                    <td>
                        <a href="<?= \yii\helpers\Url::to(['/article/edit', 'id' => $row->id]) ?>"><i
                                    class="glyphicon glyphicon-edit btn btn-success"></i></a>
                        <a href="<?= \yii\helpers\Url::to(['/article/del', 'id' => $row->id]) ?>"><i
                                    class="glyphicon glyphicon-trash btn btn-danger"></i></a>
                        <a href="<?= \yii\helpers\Url::to(['/article-content/index', 'id' => $row->id]) ?>" class="btn btn-info">文章详情</a>
                    </td>
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
