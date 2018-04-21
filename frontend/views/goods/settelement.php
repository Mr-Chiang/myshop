<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>填写核对订单信息</title>
	<link rel="stylesheet" href="/style/base.css" type="text/css">
	<link rel="stylesheet" href="/style/global.css" type="text/css">
	<link rel="stylesheet" href="/style/header.css" type="text/css">
	<link rel="stylesheet" href="/style/fillin.css" type="text/css">
	<link rel="stylesheet" href="/style/footer.css" type="text/css">

	<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/js/cart2.js"></script>
    <script type="text/javascript" src="/layer/layer.js"></script>

</head>
<body>
	<!-- 顶部导航 start -->
	<?php include Yii::getAlias('@app').'/views/common/nav.php'?>
	<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>
	
	<!-- 页面头部 start -->
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="/index/index"><img src="/images/logo.png" alt="京西商城"></a></h2>
			<div class="flow fr flow2">
				<ul>
					<li>1.我的购物车</li>
					<li class="cur">2.填写核对订单信息</li>
					<li>3.成功提交订单</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- 页面头部 end -->
	
	<div style="clear:both;"></div>

	<!-- 主体部分 start -->
	<div class="fillin w990 bc mt15">
        <form action="" id="order">
		<div class="fillin_hd">
			<h2>填写并核对订单信息</h2>
		</div>

		<div class="fillin_bd">
			<!-- 收货人信息  start-->
			<div class="address">
				<h3>收货人信息</h3>
				<div class="address_info">
                    <?php
                    $address = \frontend\models\Address::find()->where(['user_id'=>Yii::$app->user->getId()])->orderBy(['status'=>SORT_DESC])->all();
                    foreach ($address as $kk=>$vv):

                    ?>
                    <p><input type="radio" value="<?=$vv->id?>" name="address_id" <?=$vv->status?'checked=checked':''?>/><?=$vv->name?>  <?=$vv->tel?>  <?=$vv->province?> <?=$vv->city?> <?=$vv->area?> <?=$vv->detailed?> </p>

                    <?php
                    endforeach;
                    ?>
                </div>

			<!-- 收货人信息  end-->

			<!-- 配送方式 start -->
			<div class="delivery">
				<h3>送货方式</h3>

				<div class="delivery_select">
					<table>
						<thead>
							<tr>
								<th class="col1">送货方式</th>
								<th class="col2">运费</th>
								<th class="col3">运费标准</th>
							</tr>
						</thead>
						<tbody>

                        <?php
                             foreach ($pays as $kk=>$vv):
                        ?>
							<tr class="<?=$kk?'':'cur'?>">
								<td>
									<input type="radio" name="delivery" <?=$kk?'':'checked="checked"'?> value="<?=$vv->id?>"/><?=$vv->name?>
								</td>
								<td>￥<?=$vv->price?></td>
								<td><?=$vv->intro?></td>
							</tr>
                        <?php
                            endforeach;
                        ?>


						</tbody>
					</table>
				</div>
			</div> 
			<!-- 配送方式 end --> 

			<!-- 支付方式  start-->
			<div class="pay">
				<h3>支付方式</h3>

				<div class="pay_select">
					<table>
                        <?php
                           foreach ($delivery as $jj=>$zz):
                        ?>
						<tr class="<?=$jj?'':'cur'?>">
							<td class="col1"><input type="radio" name="pay" <?=$jj?'':'checked="checked"'?> value="<?=$zz->id?>"/><?=$zz->name?></td>
							<td class="col2"><?=$zz->intro?></td>
						</tr>
                       <?php
                          endforeach;
                       ?>
					</table>
				</div>
			</div>
			<!-- 支付方式  end-->

			<!-- 发票信息 start-->

			<!-- 发票信息 end-->

			<!-- 商品清单 start -->
			<div class="goods">
				<h3>商品清单</h3>
				<table>
					<thead>
						<tr>
							<th class="col1">商品</th>
							<th class="col3">价格</th>
							<th class="col4">数量</th>
							<th class="col5">小计</th>
						</tr>	
					</thead>
					<tbody>
                    <?php
                    //总金额
                    $amount = 0;
                      foreach ($carts as $kk=>$vv):
                          //通过id找出商品
                          $goods = \backend\models\Goods::findOne($vv->goods_id);
                          $amount = $amount+$vv->goods_num*$goods->price;
                    ?>
						<tr>
							<td class="col1"><a href=""><img src="<?=$goods->logo?>" alt="" /></a>  <strong><a href=""><?=$goods->name?></a></strong></td>
							<td class="col3">￥<?=$goods->price?></td>
							<td class="col4"><?=$vv->goods_num?></td>
							<td class="col5"><span>￥<?=$vv->goods_num*$goods->price?></span></td>
						</tr>
                    <?php
                    endforeach;
                    ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5">
								<ul>
									<li>
										<span><?=count($carts)?> 件商品，总商品金额：</span>
										<em id="goodsAmount">￥<?=$amount?></em>
									</li>
									<li>
										<span>运费：</span>
										<em id="freight">￥<?=$freight=10.00?></em>
									</li>
									<li>
										<span>应付总额：
										<em id="payAmount">￥<?=$amount+$freight?></em></span>
									</li>
								</ul>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<!-- 商品清单 end -->
		
		</div>

		<div class="fillin_ft">
			<a href="javascript:void (0)" id="sub_order"><span>提交订单</span></a>
			<p>应付总额：<strong class="payAmount">￥<?=$amount+$freight?>元</strong></p>
            <input type="hidden" name="total" value="<?=$amount+$freight?>">
			
		</div>
        </form>
	</div>
	<!-- 主体部分 end -->

	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
    <?php include Yii::getAlias('@app').'/views/common/foot.php'?>
	<!-- 底部版权 end -->
        <script>
            $(function () {
                //送货方式
                $('input[name=delivery]').change(function () {
                    var freight = $(this).parent().next().text();
                    freight = Number(freight.slice(1));
                   var  goodsAmount = Number($('#goodsAmount').text().slice(1));
                    //改变运费
                    $('#freight').text('￥'+freight);
                    $('.payAmount').text('￥'+(freight+goodsAmount)+'元');
                    $('#payAmount').text('￥'+(freight+goodsAmount));
                    $('input[name=total]').val(freight+goodsAmount);

                });
                $('#sub_order').click(function () {
                    //提交订单
                    $.post('/goods/settelement',$('#order').serialize(),function (data) {
                        if(data.status){
                            location.href = "/goods/success?id="+data.id;
                        }else {
                            layer.msg(data.mes)
                        }

                    },'json');
                });
            });

        </script>
</body>
</html>
