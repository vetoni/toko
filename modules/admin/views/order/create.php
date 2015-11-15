<?php

use app\modules\checkout\models\Order;
use yii\web\View;

/**
 * @var $this View
 * @var $model Order
 */

$this->title = Yii::t('app', 'Create an order');
?>

<div class="order-create">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>