<?php

namespace app\modules\admin\controllers;

use app\components\Controller;

/**
 * Class CommentController
 * @package app\modules\admin\controllers
 */
class CommentController extends Controller
{
    /**
     * @return string
     */
    public function actionList()
    {
        return $this->render('list');
    }
}