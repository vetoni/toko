<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

if (!\Yii::$app->user->isGuest && \Yii::$app->user->identity->isAdmin()) {
    NavBar::begin([
        'brandLabel' => '<i class="glyphicon glyphicon-cog"></i> ' . Yii::t('app', 'Toko admin'),
        'brandUrl' => ['/admin'],
        'id' => 'admin_panel',
        'renderInnerContainer' => false,
        'options' => [
            'class' => 'admin-panel navbar-inverse navbar-static-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav pull-right'],
    ]);
    NavBar::end();
}