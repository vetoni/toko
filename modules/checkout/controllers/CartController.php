<?php

namespace app\modules\checkout\controllers;

use app\api\Shop;
use app\components\Controller;
use app\components\Pages;
use app\modules\checkout\models\AddToCartForm;
use app\modules\checkout\models\Cart;
use yii\web\BadRequestHttpException;

/**
 * Class CartController
 * @package app\modules\checkout\controllers
 */
class CartController extends Controller
{
    /**
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionAdd()
    {
        $form = new AddToCartForm();

        if (!$form->load(\Yii::$app->request->post())) {
            throw new BadRequestHttpException();
        }

        $cart = Cart::get();
        $cart->add($form->productId, $form->quantity);
        return $this->redirect(['index']);
    }

    /**
     * @return string
     */
    public function actionClear()
    {
        $cart = Cart::get();
        $cart->clear();
        return $this->redirect(['index']);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $cart = Cart::get();
        $cart->normalize();
        return $this->render('index', ['page' => Shop::page(Pages::SHOPPING_CART), 'cart' => $cart]);
    }
}