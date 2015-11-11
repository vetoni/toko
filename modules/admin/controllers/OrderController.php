<?php

namespace app\modules\admin\controllers;

use app\components\Controller;
use app\modules\admin\models\OrderSearch;
use app\modules\checkout\models\Order;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class OrderController
 * @package app\modules\admin\controllers
 */
class OrderController extends Controller
{
    /**
     * @return string
     */
    public function actionList()
    {
        $model = new OrderSearch();
        $dataProvider = $model->search(\Yii::$app->request->queryParams);
        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'searchModel' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Order();
        $model->loadDefaultValues();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['list']);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        /** @var Order $model */
        $model = Order::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['list']);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        /** @var Order $model */
        $model = Order::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException();
        }
        $model->delete();
        return $this->redirect(['list']);
    }
}