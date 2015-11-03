<?php

use app\models\Page;
use app\modules\file\ImageSelector;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\redactor\widgets\Redactor;
use yii\web\View;

/**
 * @var View $this
 * @var Page $model
 */

?>

<div class="product-form">
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'image')->widget(ImageSelector::className()); ?>

    <?= $form->field($model, 'type')->dropDownList(['show' => Yii::t('app', 'Show'), 'list' => Yii::t('app', 'List')]) ?>

    <?= $form->field($model, 'status')->dropDownList([Yii::t('app', 'No'), Yii::t('app', 'Yes')]) ?>

    <?= $form->field($model, 'announce')->widget(Redactor::className()); ?>

    <?= $form->field($model, 'content')->widget(Redactor::className()); ?>

    <div class="form-group form-buttons">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Url::to(['list'])) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>