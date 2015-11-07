<?php

namespace app\controllers;

use app\api\Catalog;
use app\components\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class ProductController
 * @package app\controllers
 */
class ProductController extends Controller
{
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