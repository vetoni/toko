<?php

namespace app\controllers;

use app\api\Shop;
use app\components\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class PageController
 * @package app\controllers
 */
class PageController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', ['pages' => Shop::pages(['nonSystemOnly' => 1])]);
    }

    /**
     * @param string $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        if (null === $page = Shop::page($slug)) {
            throw new NotFoundHttpException;
        }
        return  $this->render("/page/view", ['page' => $page]);
    }
}