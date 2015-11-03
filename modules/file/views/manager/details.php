<?php

use app\modules\file\models\Image;
use yii\bootstrap\Html;
use yii\helpers\Url;

/**
 * @var Image $model
 */

$size = getimagesize($model->path);
?>

<?= Html::img($model->url) ?>
<p><?= Html::a(Yii::t('app', 'Delete'), '#',
        ['class' => 'btn-delete-file', 'data-id' => $model->id, 'data-action' => Url::to(['/file/manager/delete'])]) ?></p>
<p><?= Yii::t('app', 'Title: ') . $model->original_name ?></p>
<p><?= Yii::t('app', 'Image dimensions: ') . "{$size[0]}x{$size[1]}" ?></p>
<p><?= Yii::t('app', 'File size: ') . $model->getSize() ?></p>
<p>
    <?= Html::button(Yii::t('app', 'Insert'), [
        'class' => 'btn btn-primary btn-insert',
        'data-id' => $model->id,
        'data-url' => $model->url,
        'data-thumbnail' => $model->getThumbnail(300, 300)
    ]) ?>
    <?= Html::a(Yii::t('app', 'Cancel'), '#', ['class' => 'btn-cancel']) ?>
</p>

