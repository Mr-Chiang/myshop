<div class="topnav">
    <div class="topnav_bd w1210 bc">
        <div class="topnav_left">
            <?php
            $user = Yii::$app->user->identity;
            if($user){
                $username = '：'.$user->username;
            }else{
                $username = "";
            }
            ?>
        </div>
        <div class="topnav_right fr">
            <ul>
                <li>您好<?=$username?>，欢迎来到京西！[<a href="<?php echo $username?'/user/logout?id='.$user->id:'/user/login'?>"><?php echo $username?'退出':'登录'?></a>] <?php echo $username?"":'[<a href="/user/reg">免费注册</a>]'?> </li>
                <li class="line">|</li>
                <li>我的订单</li>
                <li class="line">|</li>
                <li>客户服务</li>

            </ul>
        </div>
    </div>
</div>