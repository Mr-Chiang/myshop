<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>收货地址</title>
	<link rel="stylesheet" href="/style/base.css" type="text/css">
	<link rel="stylesheet" href="/style/global.css" type="text/css">
	<link rel="stylesheet" href="/style/header.css" type="text/css">
	<link rel="stylesheet" href="/style/home.css" type="text/css">
	<link rel="stylesheet" href="/style/address.css" type="text/css">
	<link rel="stylesheet" href="/style/bottomnav.css" type="text/css">
	<link rel="stylesheet" href="/style/footer.css" type="text/css">

	<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/js/header.js"></script>
	<script type="text/javascript" src="/js/home.js"></script>
	<script type="text/javascript" src="/js/PCASClass.js"></script>
    <script type="text/javascript" src="/layer/layer.js"></script>
</head>
<body>
		<!-- 顶部导航 start -->
	<?php include Yii::getAlias('@app').'/views/common/nav.php'?>
	<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>

	<!-- 头部 start -->
	<div class="header w1210 bc mt15">
		<!-- 头部上半部分 start 包括 logo、搜索、用户中心和购物车结算 -->
		<div class="logo w1210">
			<h1 class="fl"><a href="/index.html"><img src="/images/logo.png" alt="京西商城"></a></h1>
			<!-- 头部搜索 start -->
			<div class="search fl">
				<div class="search_form">
					<div class="form_left fl"></div>
					<form action="" name="serarch" method="get" class="fl">
						<input type="text" class="txt" value="请输入商品关键字" /><input type="submit" class="btn" value="搜索" />
					</form>
					<div class="form_right fl"></div>
				</div>
				
				<div style="clear:both;"></div>

				<div class="hot_search">
					<strong>热门搜索:</strong>
					<a href="/">D-Link无线路由</a>
					<a href="/">休闲男鞋</a>
					<a href="/">TCL空调</a>
					<a href="/">耐克篮球鞋</a>
				</div>
			</div>
			<!-- 头部搜索 end -->

			<!-- 用户中心 start-->
			<div class="user fl">
				<dl>
					<dt>
						<em></em>
						<a href="/">用户中心</a>
						<b></b>
					</dt>
					<dd>
						<div class="prompt">
							您好，请<a href="/">登录</a>
						</div>
						<div class="uclist mt10">
							<ul class="list1 fl">
								<li><a href="/">用户信息></a></li>
								<li><a href="/">我的订单></a></li>
								<li><a href="/">收货地址></a></li>
								<li><a href="/">我的收藏></a></li>
							</ul>

							<ul class="fl">
								<li><a href="/">我的留言></a></li>
								<li><a href="/">我的红包></a></li>
								<li><a href="/">我的评论></a></li>
								<li><a href="/">资金管理></a></li>
							</ul>

						</div>
						<div style="clear:both;"></div>
						<div class="viewlist mt10">
							<h3>最近浏览的商品：</h3>
							<ul>
								<li><a href="/"><img src="/images/view_list1.jpg" alt="" /></a></li>
								<li><a href="/"><img src="/images/view_list2.jpg" alt="" /></a></li>
								<li><a href="/"><img src="/images/view_list3.jpg" alt="" /></a></li>
							</ul>
						</div>
					</dd>
				</dl>
			</div>
			<!-- 用户中心 end-->

			<!-- 购物车 start -->
			<div class="cart fl">
				<dl>
					<dt>
						<a href="/">去购物车结算</a>
						<b></b>
					</dt>
					<dd>
						<div class="prompt">
							购物车中还没有商品，赶紧选购吧！
						</div>
					</dd>
				</dl>
			</div>
			<!-- 购物车 end -->
		</div>
		<!-- 头部上半部分 end -->
		
		<div style="clear:both;"></div>

		<!-- 导航条部分 start -->
			<?php include Yii::getAlias('@app').'/views/common/category.php'?>
		<!-- 导航条部分 end -->
	</div>
	<!-- 头部 end-->
	
	<div style="clear:both;"></div>

	<!-- 页面主体 start -->
	<div class="main w1210 bc mt10">
		<div class="crumb w1210">
			<h2><strong>我的XX </strong><span>> 我的订单</span></h2>
		</div>
		
		<!-- 左侧导航菜单 start -->
		<div class="menu fl">
			<h3>我的XX</h3>
			<div class="menu_wrap">
				<dl>
					<dt>订单中心 <b></b></dt>
					<dd><b>.</b><a href="/">我的订单</a></dd>
					<dd><b>.</b><a href="/">我的关注</a></dd>
					<dd><b>.</b><a href="/">浏览历史</a></dd>
					<dd><b>.</b><a href="/">我的团购</a></dd>
				</dl>

				<dl>
					<dt>账户中心 <b></b></dt>
					<dd class="cur"><b>.</b><a href="/">账户信息</a></dd>
					<dd><b>.</b><a href="/">账户余额</a></dd>
					<dd><b>.</b><a href="/">消费记录</a></dd>
					<dd><b>.</b><a href="/">我的积分</a></dd>
					<dd><b>.</b><a href="/">收货地址</a></dd>
				</dl>

				<dl>
					<dt>订单中心 <b></b></dt>
					<dd><b>.</b><a href="/">返修/退换货</a></dd>
					<dd><b>.</b><a href="/">取消订单记录</a></dd>
					<dd><b>.</b><a href="/">我的投诉</a></dd>
				</dl>
			</div>
		</div>
		<!-- 左侧导航菜单 end -->

		<!-- 右侧内容区域 start -->
		<div class="content fl ml10">

           <!-- 地址列表 start -->
			<div class="address_hd">
				<h3>收货地址薄</h3>
                <?php
                $a = 1;
                $count = \frontend\models\Address::find()->count('id');
                    foreach ($data as $k):
                        ?>
				<dl class="<?php echo $a==$count?'last':''?>"><!-- 最后一个dl 加类last -->
					<dt><?php echo $a.' . '.$k->name.' '.$k->province.' '. $k->city.' '. $k->area. ' '. $k->detailed. ' '. $k->tel?></dt>
					<dd>
						<a href="">修改</a>
						<a href="/address/del?id=<?php echo $k->id?>">删除</a>
                        <?php
                         if($a!=1){
                             echo '<a href="/address/default?id='.$k->id.'">设为默认地址</a>';
                         }else{
                             echo '<font style="color: red">默认地址</font>';
                         }
                        ?>

					</dd>
				</dl>

                <?php $a++;endforeach;?>
			</div>
                <!-- 地址列表 end -->
            <!-- 新增地址 start -->
			<div class="address_bd mt10">
				<h4>新增收货地址</h4>
				<form action="" name="address_form" id="address_form">
						<ul>
							<li>
								<label for=""><span>*</span>收 货 人：</label>
								<input type="text" name="Address[name]" id="name" class="txt" />
							</li>
							<li>
								<label for=""><span>*</span>所在地区：</label>
								<select name="Address[province]" id="province">
								</select>

								<select name="Address[city]" id="city">
								</select>

								<select name="Address[area]" id="area">
								</select>
							</li>
							<li>
								<label for=""><span>*</span>详细地址：</label>
								<input type="text" name="Address[detailed]" id="detailed" class="txt address"  />
							</li>
							<li>
								<label for=""><span>*</span>手机号码：</label>
								<input type="text" name="Address[tel]" id="tel" class="txt" />
							</li>
							<li>
								<label for="">&nbsp;</label>
								<input type="checkbox" name="Address[status]" id="status" class="check" />设为默认地址
							</li>
							<li>
								<label for="">&nbsp;</label>
								<input type="button" class="btn" value="保存" id="sub_data"/>
							</li>
						</ul>
					</form>
			</div>
            <!-- 新增地址 end -->
		</div>
		<!-- 右侧内容区域 end -->
	</div>
	<!-- 页面主体 end-->

	<div style="clear:both;"></div>

	<!-- 底部导航 start -->
	<div class="bottomnav w1210 bc mt10">
		<div class="bnav1">
			<h3><b></b> <em>购物指南</em></h3>
			<ul>
				<li><a href="/">购物流程</a></li>
				<li><a href="/">会员介绍</a></li>
				<li><a href="/">团购/机票/充值/点卡</a></li>
				<li><a href="/">常见问题</a></li>
				<li><a href="/">大家电</a></li>
				<li><a href="/">联系客服</a></li>
			</ul>
		</div>
		
		<div class="bnav2">
			<h3><b></b> <em>配送方式</em></h3>
			<ul>
				<li><a href="/">上门自提</a></li>
				<li><a href="/">快速运输</a></li>
				<li><a href="/">特快专递（EMS）</a></li>
				<li><a href="/">如何送礼</a></li>
				<li><a href="/">海外购物</a></li>
			</ul>
		</div>

		
		<div class="bnav3">
			<h3><b></b> <em>支付方式</em></h3>
			<ul>
				<li><a href="/">货到付款</a></li>
				<li><a href="/">在线支付</a></li>
				<li><a href="/">分期付款</a></li>
				<li><a href="/">邮局汇款</a></li>
				<li><a href="/">公司转账</a></li>
			</ul>
		</div>

		<div class="bnav4">
			<h3><b></b> <em>售后服务</em></h3>
			<ul>
				<li><a href="/">退换货政策</a></li>
				<li><a href="/">退换货流程</a></li>
				<li><a href="/">价格保护</a></li>
				<li><a href="/">退款说明</a></li>
				<li><a href="/">返修/退换货</a></li>
				<li><a href="/">退款申请</a></li>
			</ul>
		</div>

		<div class="bnav5">
			<h3><b></b> <em>特色服务</em></h3>
			<ul>
				<li><a href="/">夺宝岛</a></li>
				<li><a href="/">DIY装机</a></li>
				<li><a href="/">延保服务</a></li>
				<li><a href="/">家电下乡</a></li>
				<li><a href="/">京东礼品卡</a></li>
				<li><a href="/">能效补贴</a></li>
			</ul>
		</div>
	</div>
	<!-- 底部导航 end -->

	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
<?php include Yii::getAlias('@app').'/views/common/foot.php'?>
	<!-- 底部版权 end -->

        <script>
            new PCAS("Address[province]","Address[city]","Address[area]");

            $(function () {
                $("#sub_data").click(function () {
                    //监听提交按钮
                    //发起ajax请求
                    $.post('/address/add',$('#address_form').serialize(),function (data) {
//                        console.debug(data)
                        if(data.status){
                            layer.msg('添加成功');
                            setTimeout(function(){
                                //两秒后跳转
                                location.href = "/address/index";
                            },1000);
                        }else {
                           $.each(data.data,function (k,v) {
                               if(k=='province'){
                                   v[0] ='信息填写不完整'
                               }
                                   if (k != 'area' && k!='city') {
                                       layer.tips(v[0], '#' + k, {
                                           tips: [2, '#0FA6D8'],
                                           tipsMore: true
                                       });
                                   }

                            });
                        }
                    },'json');
                });
            });
        </script>
</body>
</html>

