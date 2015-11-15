<?php

use app\api\CategoryObject;
use yii\bootstrap\Html;
use yii\widgets\Breadcrumbs;

/**
 * @var CategoryObject $category
 */

$this->title = Html::encode($category->model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shop'), 'url' => ['category/index']];
foreach ($category->getNodePath() as $node) {
    $this->params['breadcrumbs'][] = ['label' => $node->name, 'url' => ['category/view', 'slug' => $node->slug]];
}
?>

<div class="shop-page">
    <div class="row">
        <div class="col-md-12">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <div class="header">
                <h1><?= $this->title ?></h1>
                <p><?= $category->model->announce ?></p>
            </div>
        </div>
    </div>

    <?php if ($category->isLeaf()):
        $products = $category->products(['sort' => [
            'attributes' => [ 'name', 'price', 'rating']
        ]]);
        ?>
        <div class="link-sorter">
            <span class="caption"><?= Yii::t('app', 'Order by:') ?></span><?= $category->sorter() ?>
        </div>
        <div class="bordered">
            <?= $this->render('/product/_list', ['products' => $products, 'pager' => $category->pager()]) ?>
        </div>
    <?php else: ?>
        <div class="bordered">
            <?= $this->render('_list', ['categories' => $category->children(), 'pager' => $category->pager()]) ?>
        </div>
    <?php endif; ?>
</div>