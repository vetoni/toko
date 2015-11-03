<?php


use app\modules\file\models\Image;
use yii\bootstrap\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/**
 * @var Image[] $images
 * @var string $id
 * @var string $name
 */

$buttonCaption = $options['multiple'] ? Yii::t('app', 'Add image') : Yii::t('app', 'Select image');
?>

<div id="<?= $id ?>">
<ul class="file-manager-images">
    <?php foreach ($images as $image) : ?>
        <li>
            <?= Html::button('<i class="glyphicon glyphicon-remove-circle"></i>', ['class' => 'btn-remove']) ?>
            <?= Html::img($image->getThumbnail(300, 300)) ?>
            <?= Html::hiddenInput("{$options['name']}[{$image->id}]", $image->url); ?>
        </li>
    <?php endforeach; ?>
</ul>

<?php Modal::begin([
    'header' => Html::tag('h2', Yii::t('app', 'Image manager')),
    'toggleButton' => ['label' => $buttonCaption, 'class' => 'btn btn-default'],
    'size' => Modal::SIZE_LARGE
]);?>
<?php Modal::end(); ?>
</div>
