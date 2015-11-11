<?php

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Activate account')];
$this->title = Yii::t('app', 'Activate account');
?>

<h1><?= $this->title ?></h1>

<div class="well">
    <?= Yii::$app->session->getFlash('message'); ?>
</div>