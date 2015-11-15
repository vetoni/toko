<?php

use app\api\NewsItemObject;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;

/**
 * @var View $this
 * @var NewsItemObject $newsItem
 */

$this->title = Html::encode($newsItem->model->name);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News'), 'url' => ['/news/index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => [Url::to()]];

?>

<div class="shop-page">
    <div class="row">
        <div class="col-md-12">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </div>
        <div class="col-md-12">
            <h1>
                <?= $newsItem->model->name ?>
            </h1>
            <div class="thumbnail no-border">
                <?= Html::img($newsItem->getImageUrl()) ?>
            </div>
            <?= $newsItem->model->content ?>
        </div>
    </div>
</div>

