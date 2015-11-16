<?php

use app\helpers\CurrencyHelper;
use app\modules\checkout\models\Order;
use yii\bootstrap\Html;

/**
 * @var Order $order
 */
?>

<h1><?= Yii::t('app', 'Thanks for the order') ?></h1>
<table>
    <tbody>
    <tr>
        <th><?= Yii::t('app', 'ID') ?></th>
        <td><?= $order->id ?></td>
    </tr>
    <tr>
        <th><?= Yii::t('app', 'Date') ?></th>
        <td><?= Yii::$app->formatter->asDatetime($order->created_at) ?></td>
    </tr>
    <tr>
        <th><?= Yii::t('app', 'Status') ?></th>
        <td><?= $order->getStatusText() ?></td>
    </tr>
    <tr>
        <th><?= Yii::t('app', 'Currency') ?></th>
        <td><?= $order->currency_code ?></td>
    </tr>
    <tr>
        <th><?= Yii::t('app', 'Name') ?></th>
        <td><?= $order->name ?></td>
    </tr>
    <tr>
        <th><?= Yii::t('app', 'Address') ?></th>
        <td><?= $order->address ?></td>
    </tr>
    <tr>
        <th><?= Yii::t('app', 'Phone') ?></th>
        <td><?= $order->phone ?></td>
    </tr>
    <tr>
        <th><?= Yii::t('app', 'Email') ?></th>
        <td><?= $order->email ?></td>
    </tr>
    <tr>
        <th><?= Yii::t('app', 'Comment') ?></th>
        <td><?= nl2br(Html::encode($order->comment)) ?></td>
    </tr>
    <tr>
        <th><?= Yii::t('app', 'Discount') ?></th>
        <td><?= $order->discount * 100 ?> %</td>
    </tr>
    <tr>
        <th><?= Yii::t('app', 'Total') ?></th>
        <td><?= CurrencyHelper::format($order->total, $order->currency_code, false) ?></td>
    </tr>
    </tbody>
</table>
<h2><?= Yii::t('app', 'Products') ?></h2>
<table>
    <thead>
    <tr>
        <th align="left"><?= Yii::t('app', 'Name') ?></th>
        <th align="left"><?= Yii::t('app', 'Price') ?></th>
        <th align="left"><?= Yii::t('app', 'Quantity') ?></th>
        <th align="left"><?= Yii::t('app', 'Subtotal') ?></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($order->orderLines as $line):
        $product = $line->product;
        ?>
        <tr>
            <td align="left"><?= $product->name ?></td>
            <td align="left"><?= CurrencyHelper::format($line->price, $order->currency_code, false) ?></td>
            <td align="left"><?= $line->quantity ?></td>
            <td align="left"><?= CurrencyHelper::format($line->subtotal, $order->currency_code, false) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>