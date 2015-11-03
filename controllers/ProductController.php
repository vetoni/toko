<?php

namespace app\controllers;

use app\api\Catalog;
use app\assets\CatalogAsset;
use app\components\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class ProductController
 * @package app\controllers
 */
class ProductController extends Controller
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
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        $product = Catalog::product($slug);

        if (!$product) {
            throw new NotFoundHttpException();
        }

        $category = Catalog::cat($product->model->category_id);
        return $this->render('view', ['product' => $product, 'category' => $category]);
    }
}