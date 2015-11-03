<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

?>

<header>
    <?php NavBar::begin([
        'brandLabel' => 'Toko',
        'options' => ['class' => 'navbar-inverse'],
        'renderInnerContainer' => false,
    ]) ?>
    <?php echo Nav::widget([
        'encodeLabels' => false,
        'items' => [
            ['label' => '<i class="glyphicon glyphicon-refresh"></i> ' . Yii::t('app', 'Clear cache'), 'url' => '#'],
        ],
        'options' => ['class' => 'navbar-nav pull-right']
    ]) ?>
    <?php NavBar::end() ?>
</header>
