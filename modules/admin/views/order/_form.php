<?php

use app\models\Currency;
use app\models\Product;
use app\modules\user\models\Country;
use app\modules\user\models\User;
use app\widgets\BackLink;
use app\widgets\EntityDropDown;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\redactor\widgets\Redactor;
use yii\web\View;

/**
 * @var View $this
 * @var Product $model
 */


$items = [
    ['label' => BackLink::widget(['title' => Yii::t('app', 'Orders'), 'textOnly' => true]), 'url' => Url::to(['/admin/order/list'])],
];

if (!$model->isNewRecord) {
    $items[] = ['label' => Yii::t('app', 'View items'), 'url' => Url::to(['/admin/order-items/list', 'node' => $model->id])];
}

$items[count($items) - 1]['active'] = true;

echo Nav::widget([
    'encodeLabels' => false,
    'items' => $items,
    'options' => ['class' => 'nav-pills']
]);
?>

<div class="order-form">
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'currency_code')->widget(EntityDropDown::className(), [
        'items' => ArrayHelper::map(Currency::find()->all() , 'code', 'name'),
    ]); ?>

    <?= $form->field($model, 'country_id')->widget(EntityDropDown::className(), array(
        'items' => ArrayHelper::map(Country::find()->all() , 'id', 'name'),
    )); ?>

    <?= $form->field($model, 'user_id')->widget(EntityDropDown::className(), [
        'items' => ArrayHelper::map(User::find()->all() , 'id', 'name'),
    ]); ?>

    <?= $form->field($model, 'status')->widget(EntityDropDown::className(), [
        'items' => [Yii::t('app', 'New'), Yii::t('app', 'Closed'), Yii::t('app', 'Canceled')],
    ]); ?>

    <?= $form->field($model, 'discount') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'phone') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'comment')->widget(Redactor::className()); ?>

    <div class="form-group form-buttons">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Url::to(['list'])) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>