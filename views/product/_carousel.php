<?php

use app\models\Product;
use yii\bootstrap\Html;

/** @var Product $product */

echo newerton\fancybox\FancyBox::widget([
    'target' => 'a[rel=fancybox]',
    'helpers' => true,
    'mouse' => true,
    'config' => [
        'maxWidth' => '90%',
        'maxHeight' => '90%',
        'playSpeed' => 7000,
        'padding' => 0,
        'fitToView' => false,
        'width' => '70%',
        'height' => '70%',
        'autoSize' => false,
        'closeClick' => false,
        'openEffect' => 'elastic',
        'closeEffect' => 'elastic',
        'prevEffect' => 'elastic',
        'nextEffect' => 'elastic',
        'closeBtn' => false,
        'openOpacity' => true,
        'helpers' => [
            'title' => ['type' => 'float'],
            'buttons' => [],
            'thumbs' => ['width' => 68, 'height' => 50],
            'overlay' => [
                'css' => [
                    'background' => 'rgba(0, 0, 0, 0.8)'
                ]
            ]
        ],
    ]
]);
?>
<div class="product-carousel">
    <?php
    $i = 0;
    while ($i < count($product->images)) {
        $image = $product->images[$i];
        $thumb = ($i == 0)
            ? $image->getThumbnail(300,300)
            : $image->getThumbnail(64,64);
        echo Html::a(Html::img($thumb), $image->url, ['rel' => 'fancybox']);
        $i++;
    }
    ?>
</div>
