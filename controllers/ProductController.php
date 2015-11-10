<?php

namespace app\controllers;

use app\api\Catalog;
use app\api\Shop;
use app\components\Controller;
use app\components\Pages;
use app\models\Comment;
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

        $comment = new Comment();
        if (!\Yii::$app->user->isGuest && $comment->load(\Yii::$app->request->post())) {
            $comment->product_id = $product->model->id;
            $comment->user_id = \Yii::$app->user->id;
            $comment->save();
        }

        $category = Catalog::cat($product->model->category_id);
        return $this->render('view', ['product' => $product, 'category' => $category]);
    }

    /**
     * @param $q
     * @return string
     */
    public function actionSearch($q)
    {
        $products = Catalog::search($q);
        return $this->render('search', ['products' => $products, 'page' => Shop::page(Pages::SEARCH_RESULTS)]);
    }
}