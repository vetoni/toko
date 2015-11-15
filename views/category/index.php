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

$this->title = Yii::t('app', 'Shop');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => Url::to()];

?>

<div class="shop-page">
    <div class="header">
        <div class="row">
            <div class="col-md-3">
                <div class="thumbnail">
                    <?= Html::img($page->getImageUrl()) ?>
                </div>
            </div>
            <div class="col-md-9">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <div class="announce">
                    <h1><?= Html::encode($page->model->name) ?></h1>
                    <p><?= $page->model->announce ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="bordered">
        <?= $this->render('_list', ['categories' => $categories, 'pager' => Catalog::pager()]) ?>
    </div>
</div>