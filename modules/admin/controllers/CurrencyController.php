<?php

namespace app\modules\admin\controllers;

use app\components\Controller;
use app\helpers\CurrencyHelper;
use app\models\Currency;
use yii\data\ActiveDataProvider;

/**
 * Class CurrencyController
 * @package app\modules\admin\controllers
 */
class CurrencyController extends Controller
{
    /**
     * @return string
     */
    public function actionList()
    {
        return $this->getListView();
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionRefresh()
    {
        CurrencyHelper::refreshRates();
        return $this->getListView();
    }

    /**
     * @return string
     */
    protected function getListView()
    {
        $dataProvider = new ActiveDataProvider(['query' => Currency::find()]);
        return $this->render('list', ['dataProvider' => $dataProvider]);
    }
}