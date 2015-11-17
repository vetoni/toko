<?php

use app\modules\install\models\Configuration;
use yii\bootstrap\Html;
use yii\helpers\Url;
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
                <h1><?= Yii::t('app', 'Step 3 - Finish') ?></h1>
                <?= $this->render('../shared/_steps', ['currentStep' => 3]) ?>
                <div class="jumbotron">
                    <p><?= Yii::t('app', 'Installation succeeded!!!') ?></p>
                    <?= Html::a(Yii::t('app', 'Go home page'), Url::home(), ['class' => 'btn btn-large btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
    <hr>
</div>

