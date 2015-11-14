<?php

namespace app\controllers;

use app\api\Catalog;
use app\api\Shop;
use app\components\Controller;
use app\components\Pages;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;

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

    public function behaviors()
    {
        return [
            [
                'class' => VerbFilter::className(),
                'actions' => [
                    'clear-cache' => ['post'],
                ]
            ],
            [
                'class' => AccessControl::className(),
                'only' => ['clear-cache'],
                'rules' => [
                    [
                        'actions' => ['clear-cache'],
                        'allow' => true,
                        'ips' => ['127.0.0.1']
                    ]
                ]
            ]
        ];
    }

     /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', ['new_products' => Catalog::new_products(), 'page' => Shop::page(Pages::HOME_PAGE)]);
    }

    /**
     * @return string
     */
    public function actionClearCache()
    {
        Yii::$app->cache->flush();
        return Json::encode(1);
    }
}
