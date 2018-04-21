<?php
/* @var $this yii\web\View */
?>
<h1>促销管理</h1>

<p>
    <a href="<?=\yii\helpers\Url::to(['/sales-promotion/add'])?>" class="btn btn-info">添加活动</a>
</p>
<table class="table table-bordered table-hover" >
    <tr class="success" >
        <th>活动编号</th>
        <th>活动名称</th>
        <th>活动简介</th>
        <th>活动商品</th>
        <th>活动状态</th>
        <th>活动开始时间</th>
        <th>活动结束时间</th>
        <th>操作</th>
    </tr>
    <?php
        foreach ($model as $row):
            if($row->is_display) {
                ?>
                <tr>
                    <th><?= $row->sn ?></th>
                    <th><?= $row->name ?></th>
                    <th><?= $row->intro ?></th>
                    <th><?php
                        $str = "";
                        foreach($goods as $k){
                            if($k['sales_id']==$row->id){
                                $str = $str.$k['name'].'，';
                            }
                        }
                        echo rtrim($str,'，');

                        ?></th>
                    <th><?php
                        echo $row->status ? '上线' : '结束';
                        ?></th>
                    <th><?= date('Y-m-d H:i:s',$row->start_time) ?></th>
                    <th><?= date('Y-m-d H:i:s',$row->end_time) ?></th>
                    <th>
                        <a href="<?= \yii\helpers\Url::to(['/sales-promotion/edit', 'id' => $row->id]) ?>"><i
                                    class="glyphicon glyphicon-edit btn btn-success"></i></a>
                        <a href="<?= \yii\helpers\Url::to(['/sales-promotion/del', 'id' => $row->id]) ?>"><i
                                    class="glyphicon glyphicon-trash btn btn-danger"></i></a>
                    </th>
                </tr>
                <?php
            }
       endforeach;
    ?>
</table>
<?php
echo  \yii\widgets\LinkPager::widget([
    'pagination' => $pages,
    'nextPageLabel' => '下一页',
    'prevPageLabel' => '上一页',
]);
?>
