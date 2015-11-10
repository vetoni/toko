<?php

namespace app\controllers;

use app\api\Catalog;
use app\api\Shop;
use app\components\Controller;
use app\components\Pages;
use yii\web\NotFoundHttpException;

/**
 * Class CategoryController
 * @package app\controllers
 */
class CategoryController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('/category/index', [
            'categories' => Catalog::cats(),
            'page' => Shop::page(Pages::SHOP_BY_CATEGORY)
        ]);
    }

    /**
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        $category = Catalog::cat($slug);
        if (!$category) {
            throw new NotFoundHttpException();
        }
        return $this->render('/category/view', [
            'category' => $category,
            'page' => Shop::page('catalog')
        ]);
    }
}