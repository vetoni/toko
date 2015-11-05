<?php

use yii\bootstrap\Nav;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/**
 * @var ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('app', 'Currencies');

echo Nav::widget([
    'encodeLabels' => false,
    'items' => [
        ['label' => Yii::t('app', 'Refresh rates'), 'url' => Url::to(['/admin/currency/refresh']), 'active' => true],
    ],
    'options' => ['class' => 'nav-pills']
]);

echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'name',
        'code',
        [
           'attribute' => 'is_default',
            'value' => function($data) {
                return $data->is_default ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            }
        ],
        'rate'
    ]
]);
