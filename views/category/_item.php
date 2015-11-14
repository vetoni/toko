<?php

use app\api\CategoryObject;
use yii\bootstrap\Html;
use yii\helpers\Url;

/** @var CategoryObject $category */

$url = Url::to(['category/view', 'slug' => $category->model->slug]);
?>

<div class="col-md-3">
    <div class="thumbnail">
        <a class="image" href="<?= $url ?>">
            <?= Html::img($category->thumb(300, 300)) ?>
        </a>
        <p class="caption">
            <a href="<?= $url ?>"><?= $category->model->name ?></a>
        </p>
    </div>
</div>