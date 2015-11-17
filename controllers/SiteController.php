<?php

namespace app\controllers;

use app\api\Catalog;
use app\api\Shop;
use app\components\Controller;
use app\components\Pages;
use app\models\ContactForm;
use app\models\Settings;
use app\modules\user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => VerbFilter::className(),
                'actions' => [
                    'clear-cache' => ['post'],
                ]
            ],
            [
                'class' => AccessControl::className(),
                'only' => ['clear-cache'],
                'rules' => [
                    [
                        'actions' => ['clear-cache'],
                        'allow' => true,
                        'ips' => ['127.0.0.1']
                    ]
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', ['new_products' => Catalog::new_products(), 'page' => Shop::page(Pages::HOME_PAGE)]);
    }

    /**
     * @return string
     */
    public function actionClearCache()
    {
        Yii::$app->cache->flush();
        return Json::encode(1);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionContact()
    {
        $page = Shop::page(Pages::CONTACT);
        $model = new ContactForm();
        if (!Yii::$app->user->isGuest) {
            /** @var User $identity */
            $identity = Yii::$app->user->identity;
            $model->name = $identity->name;
            $model->email = $identity->email;
        }
        if ($model->load(Yii::$app->request->post()) && $model->contact(Settings::value('general', 'shopEmail'))) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
            'page' => $page
        ]);
    }

    /**
     * @return string
     */
    public function actionFaq()
    {
        return $this->render('faq', ['page' => Shop::page(Pages::FAQ)]);
    }

    /**
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about', ['page' => Shop::page(Pages::ABOUT)]);
    }
}
