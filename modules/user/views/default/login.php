<?php

use app\modules\user\models\LoginForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var $model LoginForm
 */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sign in')];
$this->title = Yii::t('app', 'Sign in');
?>

<h1><?= $this->title ?></h1>

<div class="well col-md-6">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'remember_me')->checkbox() ?>

    <?= Html::submitButton(Yii::t('app', 'Sign in'), ['class' => 'btn btn-primary']) ?>

    <?= Html::a(Yii::t('app', 'Create account'), ['default/register']) ?> |

    <?= Html::a(Yii::t('app', 'Forgot password?'), ['default/forgot-password']) ?>

    <?php ActiveForm::end() ?>

</div>