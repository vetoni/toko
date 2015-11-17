<?php

use app\modules\admin\models\GeneralSettings;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\web\View;

/**
 * @var View $this
 * @var GeneralSettings $model
 */

$this->title = Yii::t('app', 'General settings');

?>

<?= $this->render('/shared/alert', ['class' => 'success', 'text' => Yii::$app->session->getFlash('status')]) ?>

<section>
    <?php $form = ActiveForm::begin() ?>
    <h4><?= Yii::t('app', 'Stock indicators') ?></h4>
    <?= $form->field($model, 'stock.lowstock') ?>
    <?= $form->field($model, 'stock.outofstock') ?>
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end() ?>
</section>

