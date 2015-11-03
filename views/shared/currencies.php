<?php

use yii\bootstrap\Nav;

Nav::begin([
    'encodeLabels' => false,
    'items' => [
        ['label' => '€', 'url' => '#'],
        ['label' => '$', 'url' => '#'],
        ['label' => '₽', 'url' => '#', 'active' => true]
    ],
    'options' => ['class' =>'currencies navbar-nav pull-right']
]);
Nav::end();
