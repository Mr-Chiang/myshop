<?php
/* @var $this yii\web\View */
?>
<h1>商品管理</h1>
<br>
<p>
    <a href="<?=yii\helpers\Url::to(['goods/add'])?>" class="btn btn-info pull-left">添加商品</a>
    <div class="pull-right" style="margin-bottom: 10px;">
        <input id="key" type="text" placeholder="按编号、名称查询" value="<?=Yii::$app->request->get('key')?>">&nbsp;
        <input id="minPrice" type="text" placeholder="最低价" size="3px" value="<?=Yii::$app->request->get('minPrice')?>">-
        <input id="maxPrice" type="text" placeholder="最高价" size="3px" value="<?=Yii::$app->request->get('maxPrice')?>">&nbsp;
        <button id="search" class="btn btn-success"><i class="glyphicon glyphicon-search"></i></button></div>
</p>
<table class="table table-condensed table-bordered table-hover">
    <tr class="success">
        <th>编号</th>
        <th>图片</th>
        <th>名称</th>
<!--        <th>简介</th>-->
        <th>分类</th>
        <th>市场价</th>
        <th>本店售价</th>
        <th>排行</th>
        <th>品牌</th>
        <th>库存</th>
        <th>状态</th>
<!--        <th>创建时间</th>-->
        <th>修改时间</th>
        <th>操作</th>
    </tr>
    <?php
        foreach($model as $row):
        if($row->is_display==1){
    ?>

            <tr>
            <td><?=$row->sn?></td>
            <td><img src="<?=$row->logo?>" width="40px"></td>
            <td><?=$row->name?></td>

            <td><?=\backend\models\Category::findOne(['id'=>$row->category_id])->name?></td>
            <td><?=$row->market_price?></td>
            <td><?=$row->price?></td>
            <td><?=$row->sort?></td>
            <td><?=\backend\models\Brand::findOne(['id'=>$row->brand_id])->name?></td>
            <td><?=$row->num?></td>
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
                <td><?=date('Y-m-d H:i:s',$row->update_time)?></td>
            <td><a href="<?=yii\helpers\Url::to(['goods/edit','id'=>$row->id])?>" class="btn btn-success"><i
                            class="glyphicon glyphicon-edit"></i></a>
            <a href="<?=yii\helpers\Url::to(['goods/del','id'=>$row->id])?>" class="btn btn-danger"><i
                        class="glyphicon glyphicon-trash"></i></a>
                <a href="<?= \yii\helpers\Url::to(['/goods-content/index', 'id' => $row->id]) ?>" class="btn btn-info">更多</a>
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
<?php
$js = <<<JS
     $('#search').click(function(k,v) {
          var key = $('#key').val();
          var minPrice = $('#minPrice').val();
          var maxPrice = $('#maxPrice').val();
              //发起请求
         window.location.href = "/goods/index?key="+key+'&minPrice='+minPrice+'&maxPrice='+maxPrice;
     });



JS;

$this->registerJs($js);


?>
