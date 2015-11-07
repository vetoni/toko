<?php

use app\helpers\CurrencyHelper;
use app\models\Page;
use app\modules\checkout\models\Cart;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;

/**
 * @var Page $page
 * @var View $this
 * @var Cart $cart
 */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cart'), 'url' => ['cart/action/index']];
$this->title = Html::encode($page->name)
?>

<div class="shop-page">
    <div class="row">
        <div class="col-md-12">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <div class="header">
                <h1><?= $this->title ?></h1>
                <p><?= $page->announce ?></p>
            </div>
        </div>
    </div>
</div>
<?php if (!$cart->lines): ?>
    <p class="alert-info">
        <?= Yii::t('app', 'Your shopping cart is empty'); ?>
    </p>
    <?= Html::a(Yii::t('app', 'Continue shopping'), ['/category/index'], ['class' => 'btn btn-default']); ?>
<?php else : ?>
<div class="shopping-cart">
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th class="name"><?= Yii::t('app', 'Product name') ?></th>
            <th><?= Yii::t('app', 'Qty') ?></th>
            <th><?= Yii::t('app', 'Price') ?></th>
            <th><?= Yii::t('app', 'Total') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($cart->lines as $line):
            ?>
            <tr>
                <td class="thumb-mini">
                    <a href="<?= Url::to(['/product/view', 'slug' => $line->product->slug]) ?>">
                        <?= Html::img($line->product->thumb(64, 64)) ?>
                    </a>
                </td>
                <td class="name">
                    <a href="<?= Url::to(['/product/view', 'slug' => $line->product->slug]) ?>">
                        <?= Html::encode($line->product->name) ?>
                    </a>
                </td>
                <td>
                    <?= $line->quantity ?>
                </td>
                <td>
                    <?= CurrencyHelper::format($line->product->price) ?>
                </td>
                <td>
                    <strong><?= CurrencyHelper::format($line->subtotal) ?></strong>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($cart->discount) :  ?>
    <div class="subtotal">
        <div>
            <?= Yii::t('app', 'Subtotal') ?><span><?= CurrencyHelper::format($cart->totalExclDiscount) ?></span>
        </div>
        <div>
            <?= Yii::t('app', 'Discount') ?><span><?= CurrencyHelper::format($cart->discount) ?></span>
        </div>
    </div>
    <?php endif; ?>
    <div class="total">
        <div>
            <?= Yii::t('app', 'Total') ?><span><?= CurrencyHelper::format($cart->total) ?></span>
        </div>
    </div>
    <div class="pull-right">
        <?php $form = ActiveForm::begin(['action' => Url::to(['/checkout/cart/clear'])]) ?>
            <?= Html::submitButton(Yii::t('app', 'Clear'), ['class' => 'btn btn-default']) ?>
            <?= Html::a(Yii::t('app', 'Checkout'), ['/checkout/order/address'], ['class' => 'btn btn-primary']); ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
<?php endif; ?>