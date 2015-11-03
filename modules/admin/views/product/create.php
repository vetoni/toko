<?php

use app\models\Product;
use yii\web\View;

/**
 * @var $this View
 * @var $model Product
 */

$this->title = Yii::t('app', 'Create a product');

$this->params['breadcrumb'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['list']];
$this->params['breadcrumb'][] = $this->title;

?>

<div class="product-create">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>