<?php

use app\modules\user\models\Country;
use app\modules\user\models\User;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * @var $model User
 * @var Country[] $countries
 */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile')];

$this->title = Yii::t('app', 'Profile');
?>

<h1><?= $this->title ?></h1>

<div class="well col-md-6">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'country_id')->dropDownList(ArrayHelper::map($countries, 'id', 'name')) ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'phone') ?>

    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('app', 'Cancel'), ['details']) ?>

    <?php ActiveForm::end() ?>

</div>