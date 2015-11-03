<?php

use app\models\Product;
use yii\web\View;

/**
 * @var $this View
 * @var $model Product
 */

$this->title = Yii::t('app', 'Update a product: ') . $model->name;

$this->params['breadcrumb'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['list']];
$this->params['breadcrumb'][] = ['label' => $model->name, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumb'][] = Yii::t('app', 'Update');

?>

<div class="product-update">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
