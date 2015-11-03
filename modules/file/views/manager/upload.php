<?php

use dosamigos\fileupload\FileUploadUI;
use yii\bootstrap\Html;

/**
 * @var integer $maxFileSize
 */
?>

<div class="file-manager-upload">
<?php
echo Html::a(Yii::t('app', 'Back to file manager'), ['/file/manager/list'], ['class' => 'btn-return']);
echo FileUploadUI::widget([
    'name' => 'file',
    'url' => ['/file/action/upload'],
    'gallery' => false,
    'clientOptions' => [
        'maxFileSize' => $maxFileSize
    ],
]);
?>
</div>
