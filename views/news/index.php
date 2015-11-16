<?php

use app\api\NewsItemObject;
use app\api\Shop;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/**
 * @var NewsItemObject[] $newsItems
 */

$this->title = Yii::t('app', "News");
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News'), 'url' => ['/news/index']];

?>

<div class="shop-page">
    <div class="row">
        <div class="col-md-12">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </div>
        <?php foreach($newsItems as $newsItem): ?>
            <div class="item">
                <div class="col-md-3">
                    <a class="thumbnail no-border" href="<?= Url::to(['/news/view', 'slug' => $newsItem->model->slug]) ?>">
                        <?= Html::img($newsItem->getImageUrl()) ?>
                    </a>
                </div>
                <div class="col-md-9">
                    <em class="date">
                        <?= Yii::t('app', 'by <span class="user">{0}</span> on {1}', [
                            $newsItem->model->author->name,
                            Yii::$app->formatter->asDatetime($newsItem->model->updated_at)
                        ]) ?>
                    </em>
                    <h3>
                        <a href="<?= Url::to(['/news/view', 'slug' => $newsItem->model->slug]) ?>">
                            <?= Html::encode($newsItem->model->name) ?>
                        </a>
                    </h3>
                    <p>
                        <?= $newsItem->model->announce ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div align="right">
        <?= Shop::pager() ?>
    </div>
    <?php if (!$newsItems): ?>
        <?= Html::tag('div', Yii::t('yii', 'No results found.'), ['class' => 'no-results bordered']) ?>
    <?php endif; ?>
</div>

