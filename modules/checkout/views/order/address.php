<?php

use app\models\Page;
use app\modules\checkout\models\OrderAddress;
use app\modules\user\models\Country;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;

/**
 * @var OrderAddress $address
 * @var Country[] $countries
 * @var View $this
 * @var Page $page
 */
$this->title = Html::encode($page->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cart'), 'url' => Url::to(['/checkout/cart/index'])];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => Url::to()];

?>

<div class="shop-page">
    <div class="row">
        <div class="col-md-8">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <div class="header">
                <h1><?= $this->title ?></h1>
                <p><?= $page->announce ?></p>
            </div>
            <?php $form = ActiveForm::begin() ?>
                <?= $form->field($address, 'name') ?>
                <?= $form->field($address, 'country_id')->dropDownList(ArrayHelper::map($countries, 'id', 'name')) ?>
                <?= $form->field($address, 'email') ?>
                <?= $form->field($address, 'address') ?>
                <?= $form->field($address, 'phone') ?>
                <?= $form->field($address, 'comment')->textarea() ?>
                <?= Html::submitButton(Yii::t('app', 'Order'), ['class' => 'btn btn-success']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
