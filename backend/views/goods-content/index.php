<?php
/* @var $this yii\web\View */
?>
<h1>商品详情</h1><hr/>
<div class="col col-md-offset-5">
    <h2>
        <?=$good->name?>
    </h2>
</div>
<h6 class="col col-md-offset-3">创建时间：<?=date('Y-m-d H:i:s',$good->create_time)?>
    修改时间：<?=date('Y-m-d H:i:s',$good->update_time)?>
</h6>
<br>
<div>
<h3>商品封面：</h3>
   <img src="<?=$good->logo?>" width="200px">
</div>
<div>
    <h3>实物图：</h3>
    <?php
         foreach ($images as $k):
    ?>

    <img src="<?=$k?>" width="200px">
    <?php
        endforeach;
    ?>

</div>
<div>
    <h3>商品简介：</h3>
    <h4>
        &nbsp;&nbsp;<?=$good->intro?>
    </h4>
</div>
<div>
<h3>商品详情：</h3>
    <h4>
        &nbsp;&nbsp;<?=$model->content?>
    </h4>
</div>
<?php echo '<a href="'.\yii\helpers\Url::to(['goods/index']).'" class="btn btn-info "><i class="glyphicon glyphicon-arrow-left"></i></a>';?>

