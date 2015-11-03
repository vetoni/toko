<?php

use app\api\CategoryObject;
use app\api\ProductObject;
use app\models\AddToCartForm;
use kartik\rating\StarRating;
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

<div class="catalog-page">
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
            <div class="price bordered">
                <?php if ($product->model->old_price): ?>
                    <span><?= $product->asCurrency($product->model->old_price) ?></span>
                <?php endif; ?>
                <strong><?= $product->asCurrency($product->model->price) ?></strong>
            </div>
            <div class="clearfix">
                <div class="pull-right">
                    <?= StarRating::widget([
                        'attribute' => 'rating',
                        'model' => $product->model,
                        'pluginOptions' => ['readonly' => true, 'showClear' => false, 'size' => 'xs']
                    ])?>
                </div>
            </div>
            <div class="bordered clearfix">
                <?php $form = ActiveForm::begin(['action' => ['cart/action/add'], 'options' => ['class' => 'form-add-to-cart form-inline pull-right']]) ?>
                    <?= $form->field($formModel, 'quantity') ?>
                    <?= $form->field($formModel, 'productId')->hiddenInput()->label('') ?>
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

    $items[0]['active'] = true;

    if ($items) {
        echo Tabs::widget(['items' => $items]);
    }
    ?>
</div>