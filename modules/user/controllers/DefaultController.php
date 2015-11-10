<?php

namespace app\modules\user\controllers;


use app\api\Shop;
use app\modules\user\models\ChangePasswordForm;
use app\modules\user\models\ForgotPasswordForm;
use app\modules\user\models\LoginForm;
use app\modules\user\models\RegisterForm;
use app\modules\user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class DefaultController
 * @package app\user\controllers
 */
class DefaultController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'register', 'reset-password', 'forgot-password', 'activate'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout', 'profile', 'change-password'],
                        'roles' => ['@'],
                    ],
                ]
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', ['model' => $model]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionRegister()
    {
        $model = new RegisterForm();
        if ($model->load(\Yii::$app->request->post()) && $model->register()) {
            return $this->goHome();
        }
        return $this->render('register', ['model' => $model, 'countries' => Shop::countries()]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionProfile()
    {
        $model = User::findIdentity(\Yii::$app->user->identity->getId());
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->goHome();
        }
        return $this->render('profile', ['model' => $model, 'countries' => Shop::countries()]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();
        if ($model->load(\Yii::$app->request->post()) && $model->changePassword()) {
            return $this->goHome();
        }
        return $this->render('change_password', ['model' => $model]);
    }

    /**
     * @return string
     */
    public function actionForgotPassword()
    {
        $model = new ForgotPasswordForm();
        if ($model->load(\Yii::$app->request->post()) && $model->generatePasswordResetToken()) {
            \Yii::$app->session->setFlash('message',  \Yii::t('app', 'Email with the further instructions is sent to you.'));
        }
        return $this->render('forgot_password', ['model' => $model]);
    }

    /**
     * @return string
     */
    public function actionActivate()
    {
        $token = \Yii::$app->request->get('token');
        $user = User::findIdentityByPasswordResetToken($token);
        if ($user) {
            $user->activate();
            \Yii::$app->session->setFlash('message',  \Yii::t('app', 'Your account is activated, so you can log into website.'));
        } else {
            \Yii::$app->session->setFlash('message',  \Yii::t('app', 'The supplied token in not valid.'));
        }
        return $this->render('activate');
    }
}