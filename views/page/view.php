<?php

use app\api\PageObject;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;

/**
 * @var View $this
 * @var PageObject $page
 */

$this->title = Html::encode($page->model->name);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['/page/index']];
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
                <?= $page->model->name ?>
            </h1>
            <div class="thumbnail no-border">
                <?= Html::img($page->getImageUrl()) ?>
            </div>
            <?= $page->model->content ?>
        </div>
    </div>
</div>

