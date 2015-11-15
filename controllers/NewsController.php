<?php

namespace app\controllers;

use app\api\Shop;
use app\components\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class NewsController
 * @package app\controllers
 */
class NewsController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $newsItems = Shop::news_items();
        return $this->render('list', ['newsItems' => $newsItems]);
    }

    /**
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        $newsItem = Shop::news_item($slug);
        if (!$newsItem) {
            throw new NotFoundHttpException();
        }
        return $this->render('view', ['newsItem' => $newsItem]);
    }
}