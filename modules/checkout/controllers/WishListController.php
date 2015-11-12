<?php

namespace app\modules\checkout\controllers;

use app\api\Shop;
use app\components\Controller;
use app\components\Pages;
use app\modules\checkout\models\WishList;

/**
 * Class WishListController
 * @package app\modules\checkout\controllers
 */
class WishListController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', ['page' => Shop::page(Pages::WISH_LIST), 'wishList' => WishList::get()]);
    }
}