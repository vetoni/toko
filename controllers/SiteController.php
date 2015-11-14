<?php

namespace app\controllers;

use app\api\Catalog;
use app\api\Shop;
use app\components\Controller;
use app\components\Pages;
use Yii;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],

        ];
    }

     /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', ['new_products' => Catalog::new_products(), 'page' => Shop::page(Pages::HOME_PAGE)]);
    }
}
