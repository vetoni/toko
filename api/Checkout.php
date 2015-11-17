<?php

namespace app\api;

use app\components\Api;
use app\helpers\CurrencyHelper;
use app\modules\checkout\models\Cart;
use app\modules\checkout\models\Order;
use app\modules\checkout\models\OrderAddress;
use app\modules\checkout\models\OrderData;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;

/**
 * Class Checkout
 * @package app\api
 *
 * @method static Order order($id_token)
 * @method static Order place_order()
 * @method static Order[] user_orders()
 * @method static string pager($options = [])
 */
class Checkout extends Api
{
    /**
     * @var Order[]
     */
    public $_orders;

    /**
     * @var ActiveDataProvider
     */
    public $_adp;

    /**
     * @param array $options
     * @return string
     * @throws \Exception
     */
    public function api_pager($options = [])
    {
        return $this->_adp ? LinkPager::widget(array_merge($options, ['pagination' => $this->_adp->pagination])) : '';
    }

    /**
     * @param $token
     * @return Order
     */
    public function api_order($token)
    {
        if (!isset($this->_orders[$token])) {
            $this->_orders[$token] = $this->findOrder($token);
        }
        return $this->_orders[$token];
    }

    /**
     * @param array $options
     * @return $this
     */
    public function api_user_orders($options = [])
    {
        $query = Order::find()
            ->where(['user_id' => \Yii::$app->user->id]);
        $this->_adp = new ActiveDataProvider([
            'query' => $query,
            'pagination' => isset($options['pagination']) ? $options['pagination'] : [],
        ]);
        foreach ($this->_adp->models as $order) {
            $this->_orders[$order->id] = $order;
        }
        return $this->_adp->models;
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
            $this->reduceStocks($order);
            $cart->clear();
        }
        catch (Exception $e) {
            \Yii::warning($e->getMessage());
            return false;
        }

        $adminEmail = \Yii::$app->params['admin.email'];
        $this->sendOrderEmail($order, $order->email);
        if ($order->email != $adminEmail) {
            $this->sendOrderEmail($order, $adminEmail);
        }
        return $order;
    }

    /**
     * @param Order $order
     */
    protected function reduceStocks($order)
    {
        foreach ($order->orderLines as $line) {
            if ($line->product) {
                $line->product->inventory -= $line->quantity;
                $line->product->save();
            }
        }
    }

    /**
     * @param $order
     * @param $email
     */
    protected function sendOrderEmail($order, $email)
    {
        \Yii::$app->mailer->compose('order/confirmation', [
            'order' => $order
        ])
        ->setTo($email)
        ->setFrom(\Yii::$app->params['shop.email'])
        ->setSubject(\Yii::t('mail', 'Order confirmation'))
        ->send();
    }

    /**
     * @param $token
     * @return Order
     */
    protected function findOrder($token)
    {
        return Order::findOne(['token' => $token]);
    }
}