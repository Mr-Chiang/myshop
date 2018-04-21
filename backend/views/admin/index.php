<?php
/* @var $this yii\web\View */
?>
<h1>管理员列表</h1>
<br>
<p>
    <a href="<?=yii\helpers\Url::to(['admin/add'])?>" class="btn btn-info">添加管理员</a>
</p>
<table class="table table-condensed table-bordered table-hover">
    <tr class="success">
        <th>编号</th>
        <th>名称</th>
        <th>简介</th>
        <th>头像</th>
        <th>状态</th>
        <th>最后登录时间</th>
        <th>最后登录IP</th>
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
                <td><?php
                    if($row->status){
                        echo '激活';
                    }else{
                        echo '禁用';
                    }

                    ?></td>

            <td><?=date('Y-m-d H:i:s',$row->last_time)?></td>
                <td><?=long2ip($row->last_ip)?></td>

            <td><a href="<?=yii\helpers\Url::to(['admin/edit','id'=>$row->id])?>" class="btn btn-success"><i
                            class="glyphicon glyphicon-edit"></i></a>
            <a href="<?=yii\helpers\Url::to(['admin/del','id'=>$row->id])?>" class="btn btn-danger"><i
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
