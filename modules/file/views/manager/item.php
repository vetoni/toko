<?php

use app\modules\file\models\Image;
use yii\bootstrap\Html;
use yii\helpers\Url;

/**
 * @var Image $model
 */
?>

<a href="#" data-action="<?= Url::to(['/file/manager/details']) ?>" >
    <?= Html::img($model->url); ?>
</a>
