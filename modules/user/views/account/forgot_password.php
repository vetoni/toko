<?php

use app\modules\user\models\ForgotPasswordForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var $model ForgotPasswordForm
 */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Confirm email')];
$this->title = Yii::t('app', 'Confirm email');
?>

<h1><?= $this->title ?></h1>

<?php if (Yii::$app->session->getFlash('message')) { ?>
    <div class="well">
        <?= Yii::$app->session->getFlash('message'); ?>
    </div>
<?php } else { ?>
    <div class="well col-md-6">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'email'); ?>
        <?= Html::submitButton(Yii::t('app', 'Send token'), ['class' => 'btn btn-primary']); ?>
        <?php ActiveForm::end(); ?>
    </div>
<?php } ?>
