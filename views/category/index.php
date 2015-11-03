<?php

use app\api\Catalog;
use app\api\CategoryObject;
use app\api\PageObject;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;

/**
 * @var View $this
 * @var CategoryObject[] $categories
 * @var PageObject $page
 */

$this->title = Html::encode($page->model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shop'), 'url' => Url::to()];

?>

<div class="catalog-page">
    <div class="row">
        <div class="col-lg-3">
            <div class="thumb">
                <?= Html::img($page->model->imageUrl) ?>
            </div>
        </div>
        <div class="col-lg-9">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <div class="header">
                <h1><?= $this->title ?></h1>
                <p><?= $page->model->announce ?></p>
            </div>
        </div>
    </div>
    <div class="bordered">
        <?= $this->render('_list', ['categories' => $categories, 'pager' => Catalog::pager()]) ?>
    </div>
</div>