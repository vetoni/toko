<?php


namespace app\modules\admin\controllers;

use app\components\Controller;

/**
 * Class DashboardController
 * @package app\modules\admin\controllers
 */
class DashboardController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}