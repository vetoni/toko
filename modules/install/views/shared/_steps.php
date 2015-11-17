<?php

use app\modules\install\assets\InstallAsset;

/**
 * @var integer $currentStep
 */

$steps = [
    '1' => Yii::t('app', 'Check requirements'),
    '2' => Yii::t('app', 'Configure settings'),
    '3' => Yii::t('app', 'Finish'),
];

InstallAsset::register($this)
?>

<div class="row bs-wizard">
    <?php foreach($steps as $step => $description) : ?>
        <?php
        if($step == $currentStep){
            $state = 'active';
        } elseif($currentStep > $step) {
            $state = 'complete';
        } else {
            $state = 'disabled';
        }
        ?>
        <div class="col-xs-4 bs-wizard-step <?= $state ?>">
            <div class="text-center bs-wizard-stepnum"><? Yii::t('app', 'Step') ?> <?= $step ?></div>
            <div class="progress"><div class="progress-bar"></div></div>
            <span class="bs-wizard-dot"></span>
            <div class="bs-wizard-info text-center"><?= $description ?></div>
        </div>
    <?php endforeach; ?>
</div>
<br/>