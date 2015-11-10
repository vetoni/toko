<?php

use app\api\ProductObject;
use app\models\Comment;
use app\widgets\Rating;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\widgets\Pjax;

/**
 * @var ProductObject $product
 */

$newComment = new Comment();
$comments = $product->comments(['pagination' => ['pageSize' => 4]]);
?>

<?php Pjax::begin(['id' => 'product_comments', 'timeout' => Yii::$app->params['pjax.timeOut']]) ?>
<div class="row">
    <div class="col-md-12">
        <?php foreach($comments as $comment): ?>
            <div class="comment-item">
                <strong><?= $comment->user->name ?></strong> <em><?= Yii::$app->formatter->asDatetime($comment->created_at) ?></em>
                <p><?= Rating::widget(['name' => "Comments[$comment->id]", 'value' => $comment->rating, 'readonly' => true]) ?></p>
                <p><?= nl2br($comment->body) ?></p>
            </div>
        <?php endforeach; ?>
        <div align="right">
            <?= $product->pager() ?>
        </div>
    </div>
    <div class="col-md-6">
        <?php if (!Yii::$app->user->isGuest): ?>
            <h2><?= Yii::t('app', 'Leave a comment') ?></h2>
            <?php $form = ActiveForm::begin(['options' => ['data-pjax' => '']]) ?>
            <?= $form->field($newComment, 'rating')->widget(Rating::className())->label(false) ?>
            <?= $form->field($newComment, 'body')->textarea(['rows' => 3, 'placeholder' => Yii::t('app', 'Message')])->label(false) ?>
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
            <?php ActiveForm::end() ?>
        <?php endif; ?>
    </div>
</div>
<?php Pjax::end() ?>