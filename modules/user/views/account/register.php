<?php

use app\modules\user\models\Country;
use app\modules\user\models\RegisterForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/**
 * @var $model RegisterForm
 * @var $countries Country[]
 */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sign up')];
$this->title = Yii::t('app', 'Sign up');
?>

<h1><?= $this->title ?></h1>

<div class="well col-md-6">

<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, 'email') ?>

<?= $form->field($model, 'name') ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<?= $form->field($model, 'password_confirm')->passwordInput() ?>

<?= $form->field($model, 'country_id')->dropDownList(ArrayHelper::map($countries, 'id', 'name'))  ?>

<?= $form->field($model, 'address') ?>

<?= $form->field($model, 'phone') ?>

<?= Html::submitButton(Yii::t('app', 'Sign up'), ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end() ?>

</div>