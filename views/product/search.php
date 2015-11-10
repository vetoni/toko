<?php

use app\api\Catalog;
use app\api\ProductObject;
use app\models\Page;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/**
 * @var ProductObject[] $products
 * @var Page $page
 */

$this->title = Html::encode($page->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shop'), 'url' => ['category/index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => Url::to()];
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
    <div class="bordered">
        <?= $this->render('/product/_list', ['products' => $products, 'pager' => Catalog::pager() ]); ?>
    </div>
</div>