<?php

use app\models\Category;
use app\modules\file\ImageSelector;
use app\widgets\EntityDropDown;
use app\models\Product;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\redactor\widgets\Redactor;
use yii\web\View;

/**
 * @var View $this
 * @var Product $model
 */

?>

<div class="product-form">
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'images')->widget(ImageSelector::className()) ?>

    <?= $form->field($model, 'category_id')->widget(EntityDropDown::className(), array(
        'items' => ArrayHelper::map(Category::find()->leaves()->all() , 'id', 'name'),
    )); ?>

    <?= $form->field($model, 'old_price'); ?>

    <?= $form->field($model, 'price'); ?>

    <?= $form->field($model, 'inventory') ?>

    <?= $form->field($model, 'status')->dropDownList([Yii::t('app', 'No'), Yii::t('app', 'Yes')]) ?>

    <?= $form->field($model, 'announce')->widget(Redactor::className()); ?>

    <?= $form->field($model, 'description')->widget(Redactor::className()); ?>

    <?php
    if (!$model->isNewRecord) {
        echo $form->field($model, 'relationInfo');
    }
    ?>

    <div class="form-group form-buttons">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Url::to(['list', 'node' => $model->category_id])) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>