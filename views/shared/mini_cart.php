<?php

use app\helpers\CurrencyHelper;
use app\modules\checkout\models\Cart;
use yii\bootstrap\Nav;
use yii\helpers\Url;

$cart = Cart::get();

Nav::begin([
    'encodeLabels' => false,
    'items' => [
        ['label' => "<strong>" . CurrencyHelper::format($cart->total) . "</strong> ( {$cart->totalCount} )", 'url' => null],
        ['label' => '<i class="glyphicon glyphicon-shopping-cart"></i>', 'active' => true, 'url' => Url::to(['/checkout/cart/index'])]
    ],
    'options' => ['class' =>'mini-cart navbar-nav pull-right']
]);
Nav::end();

