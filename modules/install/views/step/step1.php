<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;

?>

<div class="jumbotron">
    <h1><?= Yii::t('app', 'Welcome to TOKO installation!') ?></h1>
    <p><?= Yii::t('app', 'First, check all requirements') ?></p>

    <?= $this->render('../shared/_steps', ['currentStep' => 1]) ?>

    <?php
    $form = ActiveForm::begin(['action' => Url::to(['second'])]);

    echo Html::submitButton(Yii::t('app', 'Install'), ['class' => 'btn btn-lg btn-primary']);

    ActiveForm::end();
    ?>
</div>

<?= $this->renderFile(Yii::getAlias('@app/requirements.php')) ?>
