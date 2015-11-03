<?php

use app\api\CategoryObject;
use yii\bootstrap\Html;

/**
 * @var CategoryObject[] $categories
 * @var string $pager
 */
?>
<div class="catalog-list-content row">
    <?php if (count($categories)) : ?>
        <?php foreach ($categories as $category): ?>
            <?= $this->render('_item', ['category' => $category]) ?>
        <?php endforeach; ?>
        <?= $pager ?>
    <?php else: ?>
        <div class="col-md-12">
            <?= Html::tag('div', Yii::t('yii', 'No results found.')) ?>
        </div>
    <?php endif; ?>
</div>