<?php
/* @var $this yii\web\View */
?>
<h1>角色管理</h1>
<br>
<p>
    <a href="<?=yii\helpers\Url::to(['role/add'])?>" class="btn btn-info">添加角色</a>
</p>
<table class="table table-condensed table-bordered table-hover">
    <tr class="success">
        <th>角色名称</th>
        <th>角色简介</th>
        <th>角色权限</th>
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
            <td><?php
                //得到当前角色对应所有权限
                $auth = Yii::$app->authManager;
                //通过角色名找到所有权限
                $pers = $auth->getPermissionsByRole($row->name);
                $str = "";
                foreach ($pers as $per){
                    $str = $str.$per->description.'，';
                }
                echo rtrim($str,'，');

                ?></td>
            <td><a href="<?=yii\helpers\Url::to(['role/edit','name'=>$row->name])?>" class="btn btn-success"><i
                            class="glyphicon glyphicon-edit"></i></a>
            <a href="<?=yii\helpers\Url::to(['role/del','name'=>$row->name])?>" class="btn btn-danger"><i
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
