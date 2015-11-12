<?php

use app\models\Comment;
use app\models\Product;
use app\modules\user\models\User;
use app\widgets\BackLink;
use app\widgets\EntityDropDown;
use app\widgets\Rating;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;

/** @var Comment $model */

$this->title = Yii::t('app', 'Update a comment: ' . $model->id . ' (' .
        Product::findOne($model->product_id)->name) . ' - ' . User::findOne($model->user_id)->name .
    ')';

echo Nav::widget([
    'encodeLabels' => false,
    'items' => [
        [
            'label' => BackLink::widget(['title' => Yii::t('app', 'Comments'), 'textOnly' => true]),
            'url' => Url::to(['/admin/comment/list']),
            'active' => true
        ],
    ],
    'options' => ['class' => 'nav-pills']
]);

?>

<div class="comment-update">
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'product_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'rating')->widget(Rating::className()) ?>

    <?= $form->field($model, 'body')->textarea() ?>

    <?= $form->field($model, 'status')->widget(EntityDropDown::className(), [
        'items' => [Yii::t('app', 'Inactive'), Yii::t('app', 'Active')],
    ]) ?>

    <div class="form-group form-buttons">
        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Url::to(['list'])) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
