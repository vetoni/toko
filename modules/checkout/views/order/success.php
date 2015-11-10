<?php

use app\models\Page;
use yii\bootstrap\Html;

/**
 * @var Page $page
 */

$this->title = Html::encode($page->name);

?>

<div class="shop-page">
    <div class="row">
        <div class="col-md-12">
            <div class="header">
                <h1><?= $this->title ?></h1>
                <p><?= $page->announce ?></p>
            </div>
        </div>
    </div>
</div>

