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
            ['label' => 'Home', 'url' => ['//site/index']],
            ['label' => 'Shop', 'url' => ['//category/index'], 'scope' => ['category', 'product']],
            ['label' => 'News', 'url' => ['//news/index'], 'scope' => ['news']],
            ['label' => 'Pages', 'url' => ['//page/index'], 'scope' => ['page']],
            ['label' => 'Contact', 'url' => ['//site/contact']],
            ['label' => 'FAQ', 'url' => ['//site/faq']],
            ['label' => 'About', 'url' => ['//site/about']],
        ],
        'options' => ['class' =>'navbar-nav navbar-static-top']
    ]);
    echo $this->render('search');
    Nav::end();
    NavBar::end();
    ?>
</div>
