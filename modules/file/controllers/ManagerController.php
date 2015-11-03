<?php

namespace app\modules\file\controllers;

use app\modules\file\FileModule;
use app\modules\file\models\Image;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class ManagerController
 * @package app\modules\file\controllers
 */
class ManagerController extends Controller
{
    /**
     * Default page size
     */
    const DEFAULT_PAGE_SIZE = 16;

    /**
     * @return string
     */
    public function actionUpload()
    {
        return $this->render('upload', ['maxFileSize' => FileModule::getInstance()->maxFileSize]);
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Image::find()->sortDate(),
            'pagination' => ['pageSize' => self::DEFAULT_PAGE_SIZE],
        ]);
        return $this->render('list', ['dataProvider' => $dataProvider]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDetails($id)
    {
        $image = Image::findOne(['id' => $id]);
        if (!$image) {
            throw new NotFoundHttpException();
        }
        return $this->renderPartial('details', ['model' => $image]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        /** @var Image $image */
        $image = Image::findOne(['id' => $id]);
        if (!$image) {
            throw new NotFoundHttpException();
        }
        $image->delete();
        return Json::encode(1);
    }
}