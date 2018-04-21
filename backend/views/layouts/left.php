<aside class="main-sidebar">

    <section class="sidebar">
        <?php
        $user = Yii::$app->user->identity;
        ?>

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $user?$user->logo:'' ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= $user?$user->name:'' ?></p>

                <a href="javascrpit:void(0)" id="status" ><i class="fa fa-circle text-success"></i> 在线</a>

<?php
$js = <<<JS
      $('#status').click(function(k,v) {
              var status = $(this).children().attr('class');
              if(status==='fa fa-circle text-success'){
                  var str = '<i class="fa fa-circle text-danger"></i> 离线';
                  $(this).html(str);
              }else {
                  var str = '<i class="fa fa-circle text-success"></i> 在线';
                  $(this).html(str);
              }
      })

JS;
$this->registerJs($js);
?>


            </div>
        </div>

<?php

$callback = function($menu){
    $data = json_decode($menu['data'], true);
    $items = $menu['children'];
    $return = [
        'label' => $menu['name'],
        'url' => [$menu['route']],
    ];
    //处理我们的配置
    if ($data) {
        //visible
        isset($data['visible']) && $return['visible'] = $data['visible'];
        //icon
        isset($data['icon']) && $data['icon'] && $return['icon'] = $data['icon'];
        //other attribute e.g. class...
        $return['options'] = $data;
    }
    //没配置图标的显示默认图标
    (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'fa fa-circle-o';
    $items && $return['items'] = $items;
    return $return;
};
?>
        <?= dmstr\widgets\Menu::widget(
            [
//                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
//                'items' => [
//                    ['label' => '是兄弟就来砍我吧！！！', 'options' => ['class' => 'header'],
//
//                        ],
//
//                ],
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],

                'items' => \mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback),

            ]
        ) ?>

    </section>

</aside>

<?php
$js = <<<JS
        
        var a = $(".sidebar-menu tree").children('i');
console.dir($(".sidebar-menu tree"));


JS;
$this->registerJs($js);
?>
