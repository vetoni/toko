<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;

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
            ['label' => '<i class="glyphicon glyphicon-refresh"></i> ' . Yii::t('app', 'Clear cache'), 'url' => '#',
                'linkOptions' => ['class' => 'btn-clear-cache', 'data-action' => Url::to(['//site/clear-cache']), 'data-message' => Yii::t('app', 'Done')]],
        ],
        'options' => ['class' => 'navbar-nav pull-right']
    ]) ?>
    <?php NavBar::end() ?>
</header>
