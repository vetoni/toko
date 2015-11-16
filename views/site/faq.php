<?php

use app\api\PageObject;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Breadcrumbs;

/**
 * @var $this View
 * @var $page PageObject
 */

$this->title = Html::encode($page->model->name);
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="shop-page">
    <div class="row">
        <div class="col-md-12">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </div>
    </div>
    <h1><?= $this->title ?></h1>
    <?= $page->model->content ?>
</div>