<?php

use app\models\NewsItem;
use yii\web\View;

/**
 * @var $this View
 * @var $model NewsItem
 */

$this->title = Yii::t('app', 'Create a news item');
?>

<div class="news-item-create">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>