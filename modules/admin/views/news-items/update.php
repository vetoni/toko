<?php

use app\models\NewsItem;
use yii\web\View;

/**
 * @var $this View
 * @var $model NewsItem
 */

$this->title = Yii::t('app', 'Update a news item: ') . $model->name;
?>
<div class="news-item-update">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
