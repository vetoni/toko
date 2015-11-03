<?php

namespace app\modules\admin\controllers;

use app\components\Controller;

/**
 * Class CategoryController
 * @package app\modules\admin\controllers
 */
class CategoryController extends  Controller
{
    /**
     * @param int $node
     * @return string
     */
    public function actionList($node = 1)
    {
        return $this->render('list', ['node' => $node]);
    }
}