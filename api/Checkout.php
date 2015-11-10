<?php

namespace app\api;

use app\components\Api;
use app\helpers\CurrencyHelper;
use app\modules\checkout\models\Cart;
use app\modules\checkout\models\Order;
use app\modules\checkout\models\OrderAddress;
use app\modules\checkout\models\OrderData;
use yii\base\Exception;

/**
 * Class Checkout
 * @package app\api
 *
 * @method static Order order($id_token)
 * @method static Order place_order()
 */
class Checkout extends Api
{
    /**
     * @var Order[]
     */
    public $_orders;

    /**
     * @param $id_token
     * @return Order
     */
    public function api_order($id_token)
    {
        if (!isset($this->_orders[$id_token])) {
            
        }
        return $this->_orders[$id_token];
    }

    /**
     * Places a new order
     */
    public function api_place_order()
    {
        $cart = Cart::get();
        $address = OrderAddress::get();
        $order = new Order();

        $order->setAttributes($address->attributes);
        $order->user_id = \Yii::$app->user->id;
        $order->currency_code = CurrencyHelper::current()->code;
        $order->discount = CurrencyHelper::convert($cart->discount);
        $order->token = \Yii::$app->security->generateRandomString(32);
        $order->status = Order::STATUS_NEW;

        try {
            if ($cart->total <= 0) {
                throw new Exception("Order with zero or less total can not be placed, ID={$order->id}");
            }
            if (!$order->save()) {
                throw new Exception("Unable to save order, ID={$order->id}");
            }
            foreach($cart->lines as $line) {
                $orderLine = new OrderData();
                $orderLine->quantity = $line->quantity;
                $orderLine->product_id = $line->product_id;
                $orderLine->price = CurrencyHelper::convert($line->price);
                $order->link('orderLines', $orderLine);
            }
            $cart->clear();
        }
        catch (Exception $e) {
            \Yii::warning($e->getMessage());
            return false;
        }
        return $order;
    }
}