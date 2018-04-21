<?php
/**
 * Created by PhpStorm.
 * User: ASUS-F550L
 * Date: 2018/3/29
 * Time: 14:24
 */

namespace frontend\controllers;


use backend\models\Delivery;
use backend\models\Goods;
use backend\models\GoodsContent;
use backend\models\Order;
use backend\models\OrderGoods;
use backend\models\Pay;
use frontend\components\ShopCart;
use frontend\models\Address;
use frontend\models\Cart;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Cookie;
use EasyWeChat\Foundation\Application;
use Endroid\QrCode\QrCode;

class GoodsController extends Controller
{
    public $enableCsrfValidation=false;
    /**
     * 商品详情
     * @param $id 商品id
     */
    public function actionContent($id){
        $goods = Goods::findOne($id);
        $goodsContent = GoodsContent::findOne(['goods_id'=>$id]);
        return $this->render('index',compact('goodsContent','goods'));
    }


    /**
     * 添加到购物车
     * @param $id 商品id
     * @param $amount 数量
     */
    public function actionCart($id){
        if(\Yii::$app->request->isPost) {
            $amount = \Yii::$app->request->post('amount')-0;
            //判断是否已登录
            if (\Yii::$app->user->isGuest) {
                //判断是否已有cookie
                (new ShopCart())->add($id,$amount)->save();
            } else {
                //已登录
                (new ShopCart())->loginCart($id,$amount);

            }
            return $this->redirect('/goods/list');
        }

    }


    /**
     * 从购物车删除商品，更改数量
     * @param $id 商品id
     * @param $amount 商品数量 未传值为删除
     */
    public function actionDel($id,$amount=0){
        if(\Yii::$app->user->isGuest){
            $data = new ShopCart();
            if($amount==0){
                //删除
                $data->del($id)->save();
            }else{
                //修改
                $data->edit($id,$amount)->save();
            }
        }else{
            if($amount==0){
                $cart = Cart::findOne(['goods_id'=>$id]);
                $cart->delete();
            }else{
                $cart = Cart::findOne(['goods_id'=>$id]);
                $cart->goods_num = $amount;
                $cart->save();
            }

        }
        return 1;

    }

    /**
     * 购物车列表
     */
    public function actionList(){
        if(\Yii::$app->user->isGuest){
            $cookies = (new ShopCart())->get();
        }else{
            $cookies = Cart::find()->where(['user_id'=>\Yii::$app->user->getId()])->asArray()->all();
            $cookies = ArrayHelper::map($cookies,'goods_id','goods_num');
        }
        return $this->render('cart1',compact('cookies'));
    }


    /**
     * 结算
     * @return string|\yii\web\Response
     */
    public function actionSettelement(){
        //判断是否已登录
        if(\Yii::$app->user->isGuest){
            //跳转登录
            return $this->redirect('/user/login');
        }else{
            //获取所购买商品
            $user_id = \Yii::$app->user->getId();
            $carts = Cart::find()->where(['user_id'=>$user_id])->all();
            //所有配送方式
            $delivery = Delivery::find()->all();
            //所有支付方式
            $pays = Pay::find()->all();
            //判断传值方式
            if(\Yii::$app->request->isPost){
                $db = \Yii::$app->db;
                $transaction = $db->beginTransaction();
                try {

                    $request = \Yii::$app->request;
                    $order = new Order();
                    //支付方式id
                    $order->pay_id = $request->post('pay');
                    //配送方式id
                    $order->delivery_id = $request->post('delivery');
                    //收货人信息
                    $address = Address::findOne(['user_id'=>\Yii::$app->user->getId(),'id'=>$request->post('address_id')]);
                    $order->province = $address->province;
                    $order->city = $address->city;
                    $order->area = $address->area;
                    //订单id
                    $sn = Order::find()->select(['sn'])->orderBy(['sn'=>SORT_DESC])->limit(1,0)->asArray()->all();
                    if($sn){
                        $order->sn = $sn[0]['sn']+1;
                    }else {
                        //初始化一个值
                        $sn =  $time = date('Ymd', time())*10000;
                        $order->sn = $sn+1;
                    }
                    $order->create_time = time();
                    $order->user_id = \Yii::$app->user->getId();
                    $order->total = $request->post('total');
                    if ($order->save()) {
                        //获取订单id
                        $orderId = \Yii::$app->db->getLastInsertID();
                        //判断是否有买商品
                        if(!$carts){
                            //抛出异常
                            throw new Exception('您还未选择商品');
                        }
                        //保存订单商品信息
                        foreach ($carts as $cart){
                            //判断库存是否足够
                            $goods = Goods::findOne(['id'=>$cart->goods_id]);
                            if($goods->num < $cart->goods_num){
//                                $goods->addError('库存不足');
                                //抛出异常
                                throw new Exception($goods->name.' 库存不足');
                            }else{
                                $goods->num = $goods->num - $cart->goods_num;
                                $goods->save(false);
                            }
                            $order_goods = new OrderGoods();
                            $order_goods->goods_id = $cart->goods_id;
                            $order_goods->goods_num = $cart->goods_num;
                            $order_goods->order_id = $orderId;
                            $order_goods->save(false);
                            //清空购物车
                            Cart::deleteAll(['user_id'=>\Yii::$app->user->getId()]);
                        }
                        $data = [
                            'status' => 1,
                            'mes' => '结算成功',
                            'id' => $orderId
                        ];
                    }else{
                        $data = [
                            'status' => 0,
                            'mes' => $order->getErrors()
                        ];
                    }

                    $transaction->commit();
                    return Json::encode($data);
                } catch(Exception $e) {

                    $transaction->rollBack();
                    $data = [
                        'status' => 0,
                        'mes' => $e->getMessage()
                    ];

                    return Json::encode($data);
                }

            }
            return  $this->render('settelement',compact('carts','delivery','pays'));
        }
    }

    /**
     * 购物成功
     * $id  订单id
    */
    public function actionSuccess($id){
        $orderOne = Order::findOne($id);
        if($orderOne->status !==1){
            return $this->render('cart2');
        }
        //判断支付方式
        switch ($orderOne->pay_id) {
            //支付宝支付
            case 2 :
                break;
            //微信支付
            case 1:

                $options = \Yii::$app->params['wx'];

                $app = new Application($options);

                $payment = $app->payment;

                $attributes = [
                    'trade_type' => 'NATIVE', // JSAPI，NATIVE，APP...
                    'body' => 'iPad mini 16G 白色',
                    'detail' => 'iPad mini 16G 白色',
                    //订单编号
                    'out_trade_no' => $orderOne->sn,
                    //订单金额
                    // 'total_fee'        => 1, // 单位：分
                    'total_fee' => $orderOne->total * 100, // 单位：分
                    'notify_url' => Url::to(['/goods/check'], true), // 支付结果通知网址，如果不设置则会使用配置里的默认地址
                    //'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
                    // ...
                ];

                $order = new \EasyWeChat\Payment\Order($attributes);

                $result = $payment->prepare($order);

                if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
                    $prepayId = $result->prepay_id;
                }
                break;
        }
                return $this->render('cart2', compact('result', 'orderOne'));
    }

    /**
     * @param $str 二维码生成
     */
    public function actionNotify($str){
        $qrCode = new QrCode($str);
        header('Content-Type: '.$qrCode->getContentType());
        echo $qrCode->writeString();
    }

    /**
     * @return mixed 判断用户是否支付成功
     */
    public function actionCheck(){
        //配置
        $option = \Yii::$app->params['wx'];
        $app = new Application($option);
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
//            $order = 查询订单($notify->out_trade_no);
            $order = Order::findOne(['sn'=>$notify->out_trade_no]);

            if (!$order) { // 如果订单不存在
                return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }

            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->status !=1) { // 假设订单字段“支付时间”不为空代表已经支付
                return true; // 已经支付成功了就不再更新了
            }

            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                //$order->paid_at = time(); // 更新支付时间为当前时间
                $order->status = 2;
            }

            $order->save(); // 保存订单

            return true; // 返回处理完成
        });

        return $response;
    }
}