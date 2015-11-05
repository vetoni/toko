<?php

use app\helpers\CurrencyHelper;
use yii\bootstrap\Nav;

Nav::begin([
    'encodeLabels' => false,
    'items' => [
        ['label' => '<strong>' . CurrencyHelper::format(0) .'</strong> ( 0 )', 'url' => null],
        ['label' => '<i class="glyphicon glyphicon-shopping-cart"></i>', 'active' => true]
    ],
    'options' => ['class' =>'mini-cart navbar-nav pull-right']
]);
Nav::end();

