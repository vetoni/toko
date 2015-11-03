<?php

use app\models\Page;
use yii\web\View;

/**
 * @var $this View
 * @var $model Page
 */

$this->title = Yii::t('app', 'Create a page');

$this->params['breadcrumb'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['list']];
$this->params['breadcrumb'][] = $this->title;

?>

<div class="product-create">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>