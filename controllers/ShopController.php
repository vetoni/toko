<?php

namespace app\controllers;

use app\components\Controller;
use app\helpers\CurrencyHelper;
use Yii;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;

/**
 * Class ShopController
 * @package app\controllers
 */
class ShopController extends Controller
{
    /**
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionSetCurrency()
    {
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException();
        }
        $code = Yii::$app->request->post('code');
        $currency = CurrencyHelper::get($code);
        CurrencyHelper::change($currency->code);
        if (!Yii::$app->request->isAjax) {
            $returnUrl = Yii::$app->request->post('returnUrl');
            if (isset($returnUrl)) {
                return $this->redirect($returnUrl);
            }
            else {
                return $this->redirect(Url::home());
            }
        }
        return Json::encode(1);
    }
}