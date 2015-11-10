<?php

namespace app\modules\checkout\controllers;

use app\api\Checkout;
use app\api\Shop;
use app\components\Controller;
use app\components\Pages;
use app\modules\checkout\models\Cart;
use app\modules\checkout\models\OrderAddress;
use app\modules\user\models\User;

/**
 * Class OrderController
 * @package app\modules\checkout\controllers
 */
class OrderController extends Controller
{
    /**
     * @return string
     */
    public function actionAddress()
    {
        $cart = Cart::get();
        if (!$cart->lines)
        {
            return $this->redirect(['/checkout/cart/index']);
        }

        $address = new OrderAddress();
        if (!\Yii::$app->user->isGuest) {
            /** @var User $identity */
            $identity = \Yii::$app->user->identity;
            $address->setAttributes($identity->attributes);
        }

        if ($address->load(\Yii::$app->request->post()) && $address->validate())
        {
            $address->save();
            $this->redirect(['place']);
        }
        return $this->render('address', [
            'address' => $address,
            'countries' => Shop::countries(),
            'page' => Shop::page(Pages::CHECKOUT)
        ]);
    }

    /**
     * @return string
     */
    public function actionPlace()
    {
        $order = Checkout::place_order();
        if ($order) {
            return $this->redirect(['success']);
        }
        else {
            return $this->redirect(['fail']);
        }
    }

    /**
     * @return string
     */
    public function actionSuccess()
    {
        return $this->render('success', ['page' => Shop::page(Pages::ORDER_SUCCESS)]);
    }

    /**
     * @return string
     */
    public function actionFail()
    {
        return $this->render('fail', ['page' => Shop::page(Pages::ORDER_FAILED)]);
    }
}