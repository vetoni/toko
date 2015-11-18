<?php

use yii\bootstrap\Html;

/**
 * @var $this \yii\web\View
 * @var $content string
 */

?>
<?php $this->beginContent('@app/views/layouts/base.php') ?>
    <div class="wrap">
        <?= $this->render('//shared/admin_panel') ?>
        <?= $this->render('//shared/header') ?>
        <a class="logo" href="/">
            <?php echo Html::img("@web/files/img/logo.png") ?>
        </a>
        <?= $this->render('//shared/menu') ?>
        <?php
        if (isset($this->blocks['topBanner'])) {
            echo $this->blocks['topBanner'];
        }
        ?>
        <div class="container"><?= $content ?></div>
    </div>
    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Vetoni <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>
<?php $this->endContent() ?>