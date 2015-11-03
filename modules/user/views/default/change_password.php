<?php

use app\modules\user\models\ChangePasswordForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var $model ChangePasswordForm
 */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Change password')];
$this->title = Yii::t('app', 'Change password');
?>

<h1><?= $this->title ?></h1>

<div class="well col-md-6">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'new_password')->passwordInput() ?>

    <?= $form->field($model, 'new_password_confirm')->passwordInput() ?>

    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end() ?>

</div>