<?php

use app\models\Product;
use yii\bootstrap\Html;

/**
 * @var Product[] $products
 * @var string $pager
 * @var string $caption
 */
?>
<div class="catalog-list row">
    <?php if (count($products)) : ?>
        <?php foreach ($products as $product): ?>
            <?= $this->render('_item', ['product' => $product]) ?>
        <?php endforeach; ?>
        <?php if (isset($pager)): ?>
            <?= $pager ?>
        <?php endif; ?>
    <?php else: ?>
        <div class="col-md-12">
            <?= Html::tag('div', Yii::t('yii', 'No results found.')) ?>
        </div>
    <?php endif; ?>
</div>