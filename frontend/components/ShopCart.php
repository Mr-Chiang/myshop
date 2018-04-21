<?php
/**
 * Created by PhpStorm.
 * User: ASUS-F550L
 * Date: 2018/3/31
 * Time: 11:22
 */

namespace frontend\components;


use frontend\models\Cart;
use yii\base\Component;
use yii\web\Cookie;

class ShopCart extends Component
{
    private $cart;
    public function __construct(array $config = [])
    {
        $this->cart = \Yii::$app->request->cookies->getValue('cart',[]);
        parent::__construct($config);
    }

    /**
     * 添加商品到购物车
     * @param $id 商品id
     * @param $num 商品数量
     */
    public function add($id,$num){
//        var_dump($this->cart);exit;
        if(array_key_exists($id,$this->cart)){
            $this->cart[$id] += $num;
        }else{
            $this->cart[$id] = (int)$num;
        }
//        var_dump((int)$id);exit;
        return $this;
    }

    public function get(){
        return $this->cart;
    }

    /**
     * 修改商品
     * @param $id 商品id
     * @param $num 商品数量
     */
    public function edit($id,$num){
        $this->cart[$id] = $num;
        return $this;
    }

    /**
     * 删除商品
     * @param $id 商品id
     * @param $num 商品数量
     */
    public function del($id){
        if($this->cart[$id]){
            unset($this->cart[$id]);
        }
        return $this;
    }


    /**
     * 保存
     */
    public function save(){
        $setCookie = \Yii::$app->response->cookies;
        //创建一个cookie对象
        $cookie = new Cookie([
            'name' => 'cart',
            'value' => $this->cart
        ]);
        //添加一个cookie
        $setCookie->add($cookie);
    }

    /**
     * 已登录状态添加购物车
     * @param $id 商品id
     * @param $amount 商品数量
     */
    public function loginCart($id,$amount){
        $user_id = \Yii::$app->user->getId();
        //取得用户购物车信息
        $cart = Cart::find()->where(['user_id'=>$user_id])->andWhere(['goods_id'=>$id])->one();
        if($cart){
            $cart->goods_num += $amount;
        }else{
            $cart = new Cart();
            $cart->user_id = $user_id;
            $cart->goods_id = $id;
            $cart->goods_num = $amount;
        }
        $cart->save();
    }
}