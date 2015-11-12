<?php

use app\helpers\CurrencyHelper;
use app\modules\checkout\models\Order;
use app\widgets\BackLink;
use yii\bootstrap\Html;
use yii\helpers\Url;

/**
 * @var Order $order
 */

?>
<h1><?= Yii::t('app', 'Order details') ?></h1>
<table class="table table-bordered table-striped">
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
</table>
<h2><?= Yii::t('app', 'Products') ?></h2>
<table class="table">
    <tbody>
    <tr>
        <th></th>
        <th><?= Yii::t('app', 'Name') ?></th>
        <th><?= Yii::t('app', 'Price') ?></th>
        <th><?= Yii::t('app', 'Quantity') ?></th>
        <th><?= Yii::t('app', 'Subtotal') ?></th>
        <th></th>
    </tr>
    <?php
        foreach($order->orderLines as $line):
        $product = $line->product;
        ?>
        <tr>
            <td>
                <a href="<?= Url::to(['/product/view', 'slug' => $product->slug]) ?>">
                    <?= Html::img($product->thumb(64,64)) ?>
                </a>
            </td>
            <td><?= Html::a($product->name, ['/product/view', 'slug' => $product->slug]) ?></td>
            <td><?= CurrencyHelper::format($line->price, $order->currency_code, false) ?></td>
            <td><?= $line->quantity ?></td>
            <td><?= CurrencyHelper::format($line->subtotal, $order->currency_code, false) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?= BackLink::widget(['title' =>  Yii::t('app', 'Order list'), 'url' => ['/checkout/order/list'], 'options' => ['class' => 'btn btn-primary']]) ?>
