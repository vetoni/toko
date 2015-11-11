<?php

namespace app\modules\admin\controllers;

use app\models\Product;
use app\modules\admin\models\AddProductForm;
use app\modules\checkout\models\Order;
use app\modules\checkout\models\OrderData;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class OrderItemsController
 * @package app\modules\admin\controllers
 */
class OrderItemsController extends Controller
{
    /**
     * @param $node
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionList($node)
    {
        /** @var Order $order */
        $order = Order::findOne($node);
        if (!$order) {
            throw new NotFoundHttpException();
        }
        $newProduct = new AddProductForm();
        if ($newProduct->load(\Yii::$app->request->post()) && $newProduct->validate()) {
            /** @var OrderData $existingLine */
            $existingLine = OrderData::find()
                ->where(['product_id' => $newProduct->product_id, 'order_id' => $order->id])
                ->one();
            if ($existingLine) {
                $existingLine->quantity += $newProduct->quantity;
                $existingLine->save();
            }
            else {
                /** @var Product $product */
                $product = Product::findOne($newProduct->product_id);
                if ($product) {
                    $line = new OrderData([
                        'product_id' => $product->id,
                        'quantity' => $newProduct->quantity,
                        'price' => $product->price
                    ]);
                    $order->link('orderLines', $line);
                }
            }
        }
        return $this->render('list', ['order' => $order, 'newProduct' => $newProduct]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        /** @var OrderData $model */
        $model = OrderData::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException();
        }

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['list', 'node' => $model->order_id]);
        }
        return $this->render('update', ['model' => $model]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        /** @var OrderData $model */
        $model = OrderData::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException();
        }
        $model->delete();
        return $this->redirect(['list', 'node' => $model->order_id]);
    }
}