<?php

use app\models\Page;
use yii\web\View;

/**
 * @var $this View
 * @var $model Page
 */

$this->title = Yii::t('app', 'Update a page: ') . $model->name;

$this->params['breadcrumb'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['list']];
$this->params['breadcrumb'][] = ['label' => $model->name, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumb'][] = Yii::t('app', 'Update');

?>

<div class="product-update">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
