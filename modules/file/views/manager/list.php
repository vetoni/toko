<?php

use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

/**
 * @var ActiveDataProvider $dataProvider
 */
?>
<?php
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => 'item',
    'summary' => '',
    'itemOptions' => ['class' => 'item'],
    'options' => ['class' => 'file-manager-list']
]);
?>
<div class="file-manager-details">
    <?= Html::a(Yii::t('app', 'Upload manager'), ['/file/manager/upload'], ['class' => 'btn btn-default']) ?>
    <div class="info"></div>
</div>