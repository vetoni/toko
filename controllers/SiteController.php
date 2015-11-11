<?php

namespace app\controllers;

use app\components\Controller;
use Yii;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],

        ];
    }

     /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
