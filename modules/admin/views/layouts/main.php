<?php

use app\modules\admin\assets\AdminAsset;
use yii\bootstrap\Html;
use yii\web\View;

/**
 * @var string $content
 * @var View $this
 */

AdminAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?= $this->render('/shared/nav') ?>
<div class="wrapper">
    <div class="sidebar-wrapper">
        <?= $this->render('/shared/sidebar') ?>
    </div>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="content-header">
                        <?= Html::encode($this->title) ?>
                    </div>
                    <div class="col-lg-12">
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

