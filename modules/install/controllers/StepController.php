<?php

namespace app\modules\install\controllers;

use app\components\Controller;

use app\helpers\Migrations;
use app\modules\install\demo\DemoData;
use app\modules\install\InstallModule;
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
        if (!$this->checkDbConnection())
        {
            return $this->showError('Cannot establish database connection. Please check your db connection settings.');
        }

        Migrations::run();

        DemoData::create([
            'admin_password' => 'test'
        ]);

        Yii::$app->cache->flush();
        $this->module->installed = true;
        return $this->render('step2');
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
    protected function checkDbConnection()
    {
        try{
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