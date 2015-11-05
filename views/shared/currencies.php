<?php

use app\api\Shop;
use yii\bootstrap\Nav;
use yii\helpers\Url;

$all = Shop::currencies();
$current = Shop::current_currency();

$items = [];
foreach ($all as $currency) {
    $items[] = [
        'label' => $currency->symbol,
        'url' => '#',
        'active' => $currency->code == $current,
        'linkOptions' => ['data-id' => $currency->code]
    ];
}

Nav::begin([
    'encodeLabels' => false,
    'items' => $items,
    'options' => ['class' => 'currencies navbar-nav pull-right', 'data-action' => Url::to(['/shop/set-currency'])]
]);
Nav::end();