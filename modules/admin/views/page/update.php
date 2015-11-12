<?php

use app\models\Page;
use yii\web\View;

/**
 * @var $this View
 * @var $model Page
 */

$this->title = Yii::t('app', 'Update a page: ') . $model->name;
?>
<div class="product-update">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
