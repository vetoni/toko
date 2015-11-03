<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

NavBar::begin([
    'id' => 'site_header',
    'options' => ['class' => 'header navbar-default navbar-static-top'],
]);
Nav::begin([
    'items' => [
        ['label' => 'Wish List', 'url' => ['/shop/wish-list']],
        ['label' => 'Shopping cart', 'url' => ['/shop/cart']],
        ['label' => 'Checkout', 'url' => ['/shop/checkout']],
    ],
    'options' => ['class' =>'navbar-nav']
]);
Nav::end();
?>

<?= $this->render('//shared/mini_cart') ?>
<?= $this->render('//shared/currencies') ?>

<?php
Nav::begin([
    'encodeLabels' => false,
    'items' => Yii::$app->user->isGuest
        ? [
            ['label' => Yii::t('app', 'Sign in'), 'url' => ['/user/default/login']],
            ['label' => Yii::t('app', 'Sign up'), 'url' => ['/user/default/register']]
        ]
        : [
            ['label' => Yii::t('app', 'My account'), 'url' => ['/user/default/profile']],
            ['label' => Yii::t('app', 'Sign out ({0})', Yii::$app->user->identity->name), 'url' => ['/user/default/logout'], 'linkOptions' => ['data-method' => 'post']]
        ],
    'options' => ['class' =>'login-links navbar-nav pull-right']
]);
Nav::end();
NavBar::end();
?>
