<div class="nav w1210 bc mt10">
    <?php
    $class = Yii::$app->controller->id.'/'.Yii::$app->controller->action->id;
    ?>
    <div class="category fl <?php echo $class!=='index/index'?'cat1':''?>"> <!-- 非首页，需要添加cat1类 -->
    <div class="cat_hd">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
        <h2>全部商品分类</h2>
        <em></em>
    </div>

    <div class="cat_bd <?php echo $class!=='index/index'?'none':''?>">
        <?php
        $categorys = \backend\models\Category::find()->where(['is_display'=>1])->all();
        foreach ($categorys as $k1=>$v1):
            if($v1->parent_id ==0) {
                ?>
                <div class="cat ">
                    <h3><a href="/index/list?id=<?=$v1->id?>"><?= $v1->name ?></a><b></b></h3>
                    <div class="cat_detail">
                        <?php
                           foreach ($categorys as $k2=>$v2):
                               if($v2->parent_id == $v1->id) {
                                   ?>
                                   <dl class="<?php echo $k2==0?'dl_1st':''?>">
                                       <dt><a href="/index/list?id=<?=$v2->id?>"><?= $v2->name ?></a></dt>
                                       <dd>
                                           <?php
                                           foreach ($categorys as $k3 => $v3):
                                               if ($v3->parent_id == $v2->id) {
                                                   ?>
                                                   <a href="/index/list?id=<?=$v3->id?>"><?=$v3->name?></a>
                                                   <?php
                                               }
                                           endforeach;
                                           ?>
                                       </dd>
                                   </dl>
                                   <?php
                               }
                               endforeach;
                           ?>
                    </div>
                </div>
                <?php
            }
        endforeach;
        ?>

    </div>

</div>
<div class="navitems fl">
    <ul class="fl">
        <li class="current"><a href="/">首页</a></li>
        <li><a href="/">电脑频道</a></li>
        <li><a href="/">家用电器</a></li>
        <li><a href="/">品牌大全</a></li>
        <li><a href="/">团购</a></li>
        <li><a href="/">积分商城</a></li>
        <li><a href="/">夺宝奇兵</a></li>
    </ul>
    <div class="right_corner fl"></div>
</div>
</div>