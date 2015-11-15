<?php

namespace app\modules\admin\controllers;

use app\components\Controller;
use app\models\Category;
use app\models\Product;
use app\modules\admin\models\ProductSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * Class ProductController
 * @package app\modules\admin\controllers
 */
class ProductController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @param $node
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionList($node)
    {
        $category = Category::findOne($node);
        if (!$category) {
            throw new NotFoundHttpException();
        }
        $model = new ProductSearch();
        $dataProvider = $model->search(\Yii::$app->request->queryParams);
        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'searchModel' => $model,
            'category' => $category
        ]);
    }

    /**
     * @param $node
     * @return string|\yii\web\Response
     */
    public function actionCreate($node)
    {
        $model = new Product();
        $model->loadDefaultValues();
        $model->category_id = $node;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['list', 'node' => $node]);
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
        /** @var Product $model */
        $model = Product::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException();
        }
        $category_id = $model->category_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['list', 'node' => $category_id]);
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
        /** @var Product $model */
        $model = Product::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException();
        }
        $model->delete();
        return $this->redirect(['list', 'node' => $model->category_id]);
    }
}