<?php

use app\models\Page;
use yii\web\View;

/**
 * @var $this View
 * @var $model Page
 */

$this->title = Yii::t('app', 'Create a page');

?>

<div class="page-create">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>