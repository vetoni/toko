<?php

use app\modules\install\models\Configuration;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Configuration $config
 */

?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="text-center">
                <h1><?= Yii::t('app', 'Step 2 - Configure settings') ?></h1>
                <?= $this->render('../shared/_steps', ['currentStep' => 2]) ?>
                <p><?= Yii::t('app', 'Note: installer will create demo content based on the language specified in Yii app config. By default english language is set. If you want different language please change \'language\' app property manually in <code>config/web.php</code> before continuing.') ?></p>
            </div>
        </div>
        <?php if (!$this->context->checkDbConnection()): ?>
            <div class="col-md-10 col-md-offset-1">
                <div class="text-center">
                    <div class="alert alert-danger"><?= Yii::t('app', 'Cannot connect to database. Please configure <code>config/db.php</code>') ?></div>
                </div>
            </div>
        <?php else: ?>
            <div class="col-md-6 col-md-offset-3 well">
                <?php $form = ActiveForm::begin() ?>
                <?= $form->field($config, 'shopEmail') ?>
                <?= $form->field($config, 'adminEmail') ?>
                <?= $form->field($config, 'adminPassword')->passwordInput() ?>
                <div class="text-center">
                    <?= Html::submitButton(Yii::t('app', 'Next'), ['class' => 'btn btn-lg btn-primary btn-block']) ?>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        <?php endif; ?>
    </div>
    <hr>
</div>

