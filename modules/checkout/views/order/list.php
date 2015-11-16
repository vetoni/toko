<?php

use app\api\Checkout;
use app\helpers\CurrencyHelper;
use app\modules\checkout\models\Order;
use app\widgets\BackLink;
use yii\bootstrap\Html;

/**
 * @var Order[] $orders
 */

$pager = Checkout::pager();
?>

<h1><?= Yii::t('app', 'My orders') ?></h1>
<table class="table">
    <thead>
    <tr>
        <th>#</th>
        <th><?= Yii::t('app', 'Name') ?></th>
        <th><?= Yii::t('app', 'Address') ?></th>
        <th><?= Yii::t('app', 'Total') ?></th>
        <th><?= Yii::t('app', 'Date') ?></th>
        <th><?= Yii::t('app', 'Status') ?></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($orders as $order): ?>
            <tr>
                <td><?= $order->id ?></td>
                <td><?= $order->name ?></td>
                <td><?= $order->address ?></td>
                <td><?= CurrencyHelper::format($order->total, $order->currency_code, false) ?></td>
                <td><?= Yii::$app->formatter->asDatetime($order->created_at) ?></td>
                <td><?= $order->getStatusText() ?></td>
                <td><?= Html::a(Yii::t('app', 'Details'), ['/checkout/order/view', 'token' => $order->token], ['class' => 'btn btn-default']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php if (isset($pager)): ?>
    <div align="right">
        <?= $pager ?>
    </div>
<?php endif; ?>
<?= BackLink::widget(['title' => Yii::t('app', 'My account'), 'url' => ['/user/account/details'], 'options' => ['class' => 'btn btn-primary']]) ?>
