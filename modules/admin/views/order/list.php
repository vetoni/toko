<?php

use app\modules\admin\models\OrderSearch;
use app\modules\checkout\models\Order;
use app\widgets\EntityDropDown;
use yii\bootstrap\Nav;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;

/**
 * @var OrderSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('app', 'Orders');

echo Nav::widget([
    'encodeLabels' => false,
    'items' => [
        ['label' => Yii::t('app', 'Create'), 'url' => Url::to(['/admin/order/create']), 'active' => true],
    ],
    'options' => ['class' => 'nav-pills']
]);

echo GridView::widget([
    'filterModel' => $searchModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'id',
            'filter' => false,
        ],
        [
            'attribute' => 'name',
            'format' => 'text',
        ],
        [
            'attribute' => 'address',
            'format' => 'text',
        ],
        [
            'attribute' => 'phone',
            'format' => 'text',
        ],
        [
            'attribute' => 'country_id',
            'format' => 'text',
        ],
        [
            'attribute' => 'status',
            'filter' => EntityDropDown::widget([
                'model' => $searchModel,
                'attribute' => 'status',
                'items' => [Yii::t('app', 'New'), Yii::t('app', 'Closed'), Yii::t('app', 'Canceled')],
            ]),
            'value' => function($order) {
                /** @var Order $order */
                return $order->getStatusText();
            }
        ],
        [
            'attribute' => 'created_at',
            'format' => 'datetime',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
        ],
    ]
]);