<?php

namespace app\modules\admin\controllers;

use app\components\Controller;

/**
 * Class NewsController
 * @package app\modules\admin\controllers
 */
class NewsController extends Controller
{
    /**
     * @return string
     */
    public function actionList()
    {
        return $this->render('list');
    }
}