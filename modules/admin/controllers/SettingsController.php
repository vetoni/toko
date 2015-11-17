<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\GeneralSettings;
use Yii;
use yii\web\Controller;

/**
 * Class SettingsController
 * @package app\modules\admin\controllers
 */
class SettingsController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $settings = new GeneralSettings();
        if ($settings->load(Yii::$app->request->post()) && $settings->validate()) {
            $settings->save();
            Yii::$app->session->setFlash('status', Yii::t('app', 'Changes are saved.'));
        }
        return $this->render('index', ['model' => $settings]);
    }
}