<?php

use app\models\Product;
use yii\web\View;

/**
 * @var $this View
 * @var $model Product
 */

$this->title = Yii::t('app', 'Create a product');
?>

<div class="product-create">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>