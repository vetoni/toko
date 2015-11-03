<?php


use app\widgets\Nav;
use yii\bootstrap\NavBar;

?>

<div class="bordered">
    <?php
    NavBar::begin([
        'id' => 'site_menu',
        'options' => ['class' => 'menu navbar-inverse navbar-static-top'],
    ]);
    Nav::begin([
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Shop', 'url' => ['/category/index'], 'scope' => ['category', 'product']],
            ['label' => 'News', 'url' => ['/news/index']],
            ['label' => 'Pages', 'url' => ['/pages/index']],
            ['label' => 'Contact', 'url' => ['page/show', 'id' => '1']],
            ['label' => 'FAQ', 'url' => ['/site/faq']],
            ['label' => 'About', 'url' => ['page/about']],
        ],
        'options' => ['class' =>'navbar-nav navbar-static-top']
    ]);
    Nav::end();
    NavBar::end();
    ?>
</div>