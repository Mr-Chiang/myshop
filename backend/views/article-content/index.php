<?php
/* @var $this yii\web\View */
?>
<?php
/* @var $this yii\web\View */
?>
<h1>文章详情</h1><hr/>
<div class="col col-md-offset-5">
    <h2><?=$model->title?></h2>
</div>
<div>
<h6 class="col col-md-offset-3">创建时间：<?=date('Y-m-d H:i:s',$model->create_time)?>
    修改时间：<?=date('Y-m-d H:i:s',$model->update_time)?>
</h6>
</div>
<div>
    <h3>商品简介：</h3>
    <h4>
        &nbsp;&nbsp;<?=$model->intro?>
    </h4>
</div>
<div>
    <h3>商品详情：</h3>
    <h4>
        &nbsp;&nbsp;<?=$content->detail?>
    </h4>
</div>
<?php echo '<a href="'.\yii\helpers\Url::to(['article/index']).'" class="btn btn-info "><i class="glyphicon glyphicon-arrow-left"></i></a>';?>


