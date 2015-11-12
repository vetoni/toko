<?php

namespace app\modules\admin\controllers;

use app\components\Controller;
use app\models\Comment;
use app\modules\admin\models\CommentSearch;
use Yii;
use yii\web\NotFoundHttpException;

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
        $model = new CommentSearch();
        $dataProvider = $model->search(\Yii::$app->request->queryParams);
        return $this->render('list', ['searchModel' => $model, 'dataProvider' => $dataProvider]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        /** @var Comment $model */
        $model = Comment::findOne($id);

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
        /** @var Comment $model */
        $model = Comment::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException();
        }
        $model->delete();
        return $this->redirect(['list']);
    }
}