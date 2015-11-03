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
            'caption' => '<h1>Headline title</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tristique arcu urna, at malesuada dui accumsan sed. Aliquam sit amet lectus a nisl imperdiet volutpat.</p>
<p><a class="btn btn-lg btn-primary">Learn more</a></p>',
            'options' => [],
        ],
        [
            'content' => @Html::img("@web/files/img/carousel-item.jpg"),
            'caption' => '<h1>Headline title</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tristique arcu urna, at malesuada dui accumsan sed. Aliquam sit amet lectus a nisl imperdiet volutpat. </p>
<p><a class="btn btn-lg btn-primary">Learn more</a></p>',
            'options' => [],
        ],
        [
            'content' => @Html::img("@web/files/img/carousel-item.jpg"),
            'caption' => '<h1>Headline title</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tristique arcu urna, at malesuada dui accumsan sed. Aliquam sit amet lectus a nisl imperdiet volutpat. </p>
<p><a class="btn btn-lg btn-primary">Learn more</a></p>',
            'options' => [],
        ],
    ],
    'controls' => [
        '<span class="glyphicon glyphicon-chevron-left"></span>',
        '<span class="glyphicon glyphicon-chevron-right"></span>',
    ],
]);
