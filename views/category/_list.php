<?php

use app\api\CategoryObject;
use yii\bootstrap\Html;

/**
 * @var CategoryObject[] $categories
 * @var string $pager
 */
?>
<div class="row">
    <?php if (count($categories)) : ?>
        <?php foreach ($categories as $category): ?>
            <?= $this->render('_item', ['category' => $category]) ?>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-md-12">
            <?= Html::tag('div', Yii::t('yii', 'No results found.'), ['class' => 'no-results']) ?>
        </div>
    <?php endif; ?>
</div>
<?php if (isset($pager)): ?>
    <div align="right">
        <?= $pager ?>
    </div>
<?php endif; ?>