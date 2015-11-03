<?php

use yii\bootstrap\Nav;

Nav::begin([
    'encodeLabels' => false,
    'items' => [
        ['label' => '<strong>₽ 0,00</strong> ( 0 )', 'url' => null],
        ['label' => '<i class="glyphicon glyphicon-shopping-cart"></i>', 'active' => true]
    ],
    'options' => ['class' =>'mini-cart navbar-nav pull-right']
]);
Nav::end();

