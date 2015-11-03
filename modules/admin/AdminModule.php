<?php


namespace app\modules\admin;

use yii\base\Module;
use yii\filters\AccessControl;

/**
 * Class AdminModule
 * @package app\modules\admin
 */
class AdminModule extends Module
{
    /**
     * @var string
     */
    public $defaultRoute = 'dashboard/index';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return !\Yii::$app->user->isGuest && \Yii::$app->user->identity->isAdmin();
                        }
                    ]
                ],
            ]
        ];
    }
}