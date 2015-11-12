<?php

use app\widgets\Nav;
use yii\bootstrap\NavBar;

NavBar::begin([
    'id' => 'site_header',
    'options' => ['class' => 'header navbar-default navbar-static-top'],
]);
Nav::begin([
    'items' => [
        ['label' => 'Wish List', 'url' => ['/checkout/wish-list/index']],
        ['label' => 'Shopping cart', 'url' => ['/checkout/cart/index']],
        ['label' => 'Checkout', 'url' => ['/checkout/order/address']],
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
            ['label' => Yii::t('app', 'Sign in'), 'url' => ['/user/account/login']],
            ['label' => Yii::t('app', 'Sign up'), 'url' => ['/user/account/register']]
        ]
        : [
            ['label' => Yii::t('app', 'My account'), 'url' => ['/user/account/details'], 'scope' => ['account']],
            ['label' => Yii::t('app', 'Sign out ({0})', Yii::$app->user->identity->name), 'url' => ['/user/account/logout'], 'linkOptions' => ['data-method' => 'post']]
        ],
    'options' => ['class' =>'login-links navbar-nav pull-right']
]);
Nav::end();
NavBar::end();
?>
