<?php

use app\api\ProductObject;
use app\helpers\CurrencyHelper;
use yii\bootstrap\Html;
use yii\helpers\Url;

/** @var ProductObject $product */

$url = Url::to(['product/view', 'slug' => $product->model->slug]);
?>

<div class="col-md-3">
    <div class="thumb">
        <a class="image" href="<?= $url ?>">
            <?= Html::img($product->thumb(300, 300)) ?>
        </a>
        <p class="caption">
            <a href="<?= $url ?>"><?= $product->model->name ?></a>
        </p>
        <p class="price"><?= CurrencyHelper::format($product->model->price) ?></p>
    </div>
</div>