<?php

use app\api\PageObject;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Breadcrumbs;

/**
 * @var $this View
 * @var $page PageObject
 */

$this->title = Html::encode($page->model->name);
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="shop-page">
    <div class="row">
        <div class="col-md-12">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </div>
    </div>
    <h1><?= $this->title ?></h1>

    <div class="row">
        <div class="col-md-6">
            <?= str_replace('%SHOP_EMAIL%', Yii::$app->params['shop.email'], $page->model->content)  ?>
        </div>
        <div class="col-md-6">
            <img src="https://api-maps.yandex.ru/services/constructor/1.0/static/?sid=E9vXA6vPbvlWDLvnMTMeXoB0B3EV46lX&width=500&height=400&lang=ru_UA&sourceType=constructor" alt=""/>
        </div>
    </div>
</div>