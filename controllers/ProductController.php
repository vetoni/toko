<?php

namespace app\controllers;

use app\api\Catalog;
use app\api\Shop;
use app\components\Controller;
use app\components\Pages;
use app\models\Comment;
use app\modules\checkout\models\AddToWishListForm;
use app\modules\checkout\models\WishList;
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
            $comment->user_id = \Yii::$app->user->id;
            $comment->status = Comment::STATUS_ACTIVE;
            $product->model->link('comments', $comment);
        }

        $wishListModel = new AddToWishListForm();
        $wishList = WishList::get();
        if ($wishListModel->load(\Yii::$app->request->post())) {
            $wishList->add($product->model->id);
        }

        $category = Catalog::cat($product->model->category_id);
        return $this->render('view', [
            'product' => $product,
            'category' => $category,
            'wishListModel' => $wishListModel,
            'inWishList' => $wishList->has($product->model->id),
        ]);
    }

    /**
     * @param $q
     * @return string
     */
    public function actionSearch($q)
    {
        $products = Catalog::search($q, ['sort' => ['attributes' => [ 'name', 'price', 'rating']]]);
        return $this->render('search', ['products' => $products, 'page' => Shop::page(Pages::SEARCH_RESULTS)]);
    }
}