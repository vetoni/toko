<?php

use app\modules\file\ImageSelector;
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

    <?= $form->field($model, 'image')->widget(ImageSelector::className()) ?>

    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>

    <?= Html::a(Yii::t('app', 'Change password'), ['default/change-password']) ?>

    <?php ActiveForm::end() ?>

</div>