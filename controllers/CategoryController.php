<?php

namespace app\controllers;

use app\api\Catalog;
use app\api\Shop;
use app\assets\CatalogAsset;
use app\components\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class CategoryController
 * @package app\controllers
 */
class CategoryController extends Controller
{
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->view->registerAssetBundle(CatalogAsset::className());
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('/category/index', [
            'categories' => Catalog::cats(),
            'page' => Shop::page(1)
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