<?php

use app\api\PageObject;
use app\api\Shop;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/**
 * @var PageObject[] $pages
 */

$this->title = Yii::t('app', "Pages");
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['/news/index']];

?>

<div class="shop-page">
    <div class="row">
        <div class="col-md-12">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </div>
        <?php foreach($pages as $page): ?>
            <div class="item">
                <div class="col-md-3">
                    <a class="thumbnail no-border" href="<?= Url::to(['/page/view', 'slug' => $page->model->slug]) ?>">
                        <?= Html::img($page->getImageUrl()) ?>
                    </a>
                </div>
                <div class="col-md-9">
                    <h3>
                        <a href="<?= Url::to(['/page/view', 'slug' => $page->model->slug]) ?>">
                            <?= Html::encode($page->model->name) ?>
                        </a>
                    </h3>
                    <p>
                        <?= $page->model->announce ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div align="right">
        <?= Shop::pager() ?>
    </div>
    <?php if (!$pages): ?>
        <?= Html::tag('div', Yii::t('yii', 'No results found.'), ['class' => 'no-results bordered']) ?>
    <?php endif; ?>
</div>