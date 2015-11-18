<?php

use app\widgets\Nav;
use yii\bootstrap\NavBar;
use yii\web\View;

/**
 * @var View $this
 */
?>

<div class="bordered">
    <?php
    NavBar::begin([
        'id' => 'site_menu',
        'options' => ['class' => 'menu navbar-inverse navbar-static-top'],
    ]);
    Nav::begin([
        'items' => [
            ['label' => Yii::t('app', 'Home'), 'url' => ['//site/index']],
            ['label' => Yii::t('app', 'Shop'), 'url' => ['//category/index'], 'scope' => ['category', 'product']],
            ['label' => Yii::t('app', 'News'), 'url' => ['//news/index'], 'scope' => ['news']],
            ['label' => Yii::t('app', 'Pages'), 'url' => ['//page/index'], 'scope' => ['page']],
            ['label' => Yii::t('app', 'Contact'), 'url' => ['//site/contact']],
            ['label' => Yii::t('app', 'FAQ'), 'url' => ['//site/faq']],
            ['label' => Yii::t('app', 'About'), 'url' => ['//site/about']],
        ],
        'options' => ['class' =>'navbar-nav navbar-static-top']
    ]);
    echo $this->render('search');
    Nav::end();
    NavBar::end();
    ?>
</div>
