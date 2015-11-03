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
     * @param string $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($slug)
    {
        if (null === $page = Shop::page($slug)) {
            throw new NotFoundHttpException;
        }
        return  $this->render("/{$slug}/{$page->model->type}", ['model' => $page->model]);
    }
}