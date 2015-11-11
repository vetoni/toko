<?php

use app\modules\checkout\models\OrderData;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;

/** @var OrderData $model */

$this->title = Yii::t('app', 'Update order');

?>

<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, 'product_id')->textInput(['readonly' => 'readonly']) ?>

<?= $form->field($model, 'quantity') ?>

<?= $form->field($model, 'price') ?>

<div class="form-group form-buttons">
    <?= Html::submitButton(Yii::t('app', 'Update'),['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('app', 'Cancel'), Url::to(['list', 'node' => $model->order_id])) ?>
</div>
<?php ActiveForm::end() ?>