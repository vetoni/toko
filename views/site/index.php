<?php

use app\api\ProductObject;
use app\models\Page;
use yii\bootstrap\Html;

/**
 * @var yii\web\View $this
 * @var Page $page
 * @var ProductObject[] $new_products
 */

$this->beginBlock('topBanner');
echo $this->render('/shared/carousel');
$this->endBlock();
?>

<div class="site-index">

    <div class="jumbotron">
        <?= $page->announce ?>
        <?= $page->content ?>

        <p><?= Html::a(Yii::t('app', 'Check our catalog'), ['/category/index'], ['class' => 'btn btn-lg btn-success']) ?></p>
    </div>

    <div class="body-content">

        <div class="new-products">
            <h2><?= Yii::t('app', '<span>New</span> products') ?></h2>
            <?= $this->render('/product/_list', ['products' => $new_products]) ?>
        </div>

        <?= $this->render('/shared/brands') ?>

    </div>
</div>
