<?php

use app\models\Product;
use yii\web\View;

/**
 * @var $this View
 * @var $model Product
 */

$this->title = Yii::t('app', 'Update a product: ') . $model->name;

?>

<div class="product-update">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
