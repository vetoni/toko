<?php

namespace app\modules\install\controllers;

use app\components\Controller;
use app\helpers\Migrations;
use app\modules\install\demo\DemoData;
use app\modules\install\InstallModule;
use app\modules\install\models\Configuration;
use Yii;

/**
 * Class StepController
 * @package app\modules\install\controllers
 *
 * @property InstallModule $module
 */
class StepController extends Controller
{
    /**
     * @return string
     */
    public function actionFirst()
    {
        return $this->render('step1');
    }

    /**
     * @return string
     */
    public function actionSecond()
    {
        $config = new Configuration([
            'shopEmail' => 'demo.toko-webshop@gmail.com',
            'adminEmail' => 'admin.toko-webshop@gmail.com',
            'adminPassword' => 'demo',
        ]);

        if ($config->load(Yii::$app->request->post()) && $config->validate()) {
            Migrations::run();
            DemoData::create($config);
            Yii::$app->cache->flush();
            $this->module->installed = true;
            return $this->redirect('finish');
        }

        return $this->render('step2', ['config' => $config]);
    }

    /**
     * @return string
     */
    public function actionFinish()
    {
        return $this->render('step3');
    }

    /**
     * @return bool
     */
    public function checkDbConnection()
    {
        try {
            Yii::$app->db->open();
            return true;
        }
        catch(\Exception $e){
            return false;
        }
    }

    /**
     * @param $text
     * @return string
     */
    protected function showError($text)
    {
        return $this->render('error', ['error' => $text]);
    }
}