<?php

use app\api\CategoryObject;
use app\api\ProductObject;
use app\helpers\CurrencyHelper;
use app\modules\checkout\models\AddToCartForm;
use app\widgets\Rating;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\bootstrap\Tabs;
use yii\web\View;
use yii\widgets\Breadcrumbs;

/**
 * @var View $this
 * @var ProductObject $product
 * @var CategoryObject $category
 */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shop'), 'url' => ['category/index']];
foreach ($category->getNodePath() as $node) {
    $this->params['breadcrumbs'][] = ['label' => $node->name, 'url' => ['category/view', 'slug' => $node->slug]];
}
$this->params['breadcrumbs'][] = ['label' => $product->model->name];
$this->title = Html::encode($product->model->name);
$formModel = new AddToCartForm(['quantity' => '1', 'productId' => $product->model->id]);
?>

<div class="shop-page">
    <div class="row">
        <div class="col-md-3">
            <?= $this->render('_carousel', ['product' => $product->model]) ?>
        </div>
        <div class="col-md-9">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []
            ]) ?>
            <h1><?= $this->title ?></h1>
            <p class="description"><?= $product->model->announce ?></p>
            <div class="price">
                <?php if ($product->model->old_price): ?>
                    <span><?= CurrencyHelper::format($product->model->old_price) ?></span>
                <?php endif; ?>
                <strong><?= CurrencyHelper::format($product->model->price) ?></strong>
            </div>
            <div class="clearfix">
                <div class="pull-right">
                    <?= Rating::widget(['name' => 'Product[rating]', 'value' => $product->rating() , 'readonly' => true]) ?>
                </div>
            </div>
            <div class="clearfix bordered">
                <?php $form = ActiveForm::begin(['action' => ['/checkout/cart/add'],
                    'options' => ['class' => 'form-add-to-cart form-inline pull-right']]) ?>
                    <?= $form->field($formModel, 'quantity') ?>
                    <?= $form->field($formModel, 'productId')->hiddenInput()->label(false) ?>
                    <?= Html::submitButton(Yii::t('app', 'Add to cart'), ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
    <?php
    $items = [];

    $items[] = [
        'label' => Yii::t('app', 'Description'),
        'content' => $product->model->description
    ];

    if ($product->related()) {
        $items[] = [
            'label' => Yii::t('app', 'Related products'),
            'content' => $this->render('_list', ['products' => $product->related()])
        ];
    }

    if (!Yii::$app->user->isGuest || (Yii::$app->user->isGuest && $product->comments())) {
        $items[] = [
            'label' => Yii::t('app', 'Comments'),
            'content' => $this->render('_comments', ['product' => $product])
        ];
    }

    $items[0]['active'] = true;

    if ($items) {
        echo Tabs::widget(['items' => $items]);
    }
    ?>
</div>