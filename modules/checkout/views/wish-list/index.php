<?php

use app\api\Catalog;
use app\models\Page;
use app\modules\checkout\models\WishList;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;

/**
 * @var Page $page
 * @var View $this
 * @var WishList $wishList
 */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wish List'), 'url' => ['/checkout/wish-list/index']];
$this->title = Html::encode($page->name);
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
<?php if (!$wishList->items): ?>
    <p class="alert-info">
        <?= Yii::t('app', 'Your wish list is empty'); ?>
    </p>
<?php else : ?>
<div class="wish-list">
    <table class="table">
        <thead>
            <tr>
                <th class="thumb-mini"></th>
                <th class="name"><?= Yii::t('app', 'Product name') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($wishList->items as $id => $item): ?>
            <?php $product = Catalog::product($id); ?>
            <?php if ($product): ?>
            <tr>
                <td class="thumb-mini">
                    <a href="<?= Url::to(['/product/view', 'slug' => $product->model->slug]) ?>">
                        <?= Html::img($product->thumb(64, 64)) ?>
                    </a>
                </td>
                <td class="name">
                    <a href="<?= Url::to(['/product/view', 'slug' => $product->model->slug]) ?>">
                        <?= Html::encode($product->model->name) ?>
                    </a>
                </td>
            </tr>
           <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
