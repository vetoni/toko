<?php
use yii\bootstrap\Carousel;
use yii\helpers\Html;

echo Carousel::widget([
    'options' => [
        'id' => 'top_slider'
    ],
    'items' => [
        [
            'content' => @Html::img("@web/files/img/carousel-item.jpg"),
            'options' => [],
        ],
        [
            'content' => @Html::img("@web/files/img/carousel-item2.jpg"),
            'options' => [],
        ],
    ],
    'controls' => [
        '<span class="glyphicon glyphicon-chevron-left"></span>',
        '<span class="glyphicon glyphicon-chevron-right"></span>',
    ],
]);
