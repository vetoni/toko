<?php
use yii\bootstrap\Html;
use yii\helpers\Url;
?>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="text-center">
                <h1><?= Yii::t('app', 'Welcome to TOKO installation!') ?></h1>
                <?= $this->render('../shared/_steps', ['currentStep' => 1]) ?>
                <p><?= Yii::t('app', 'First, check all requirements and if they are satisfied press button below') ?></p>
                <?= Html::a(Yii::t('app', 'Install'), Url::to(['second']), ['class' => 'btn btn-lg btn-primary']) ?>
            </div>
        </div>
    </div>
    <hr>
</div>
<?= $this->renderFile(Yii::getAlias('@app/requirements.php')) ?>
