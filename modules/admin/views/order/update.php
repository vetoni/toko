<?php

use app\modules\checkout\models\Order;
use yii\web\View;

/**
 * @var $this View
 * @var $model Order
 */

$this->title = Yii::t('app', 'Update an order: ') . $model->id;

?>

<div class="product-update">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
