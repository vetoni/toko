<?php

use app\modules\admin\models\PageSearch;
use app\widgets\EntityDropDown;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;

/**
 * @var PageSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('app', 'Pages');

echo Nav::widget([
    'encodeLabels' => false,
    'items' => [
        ['label' => Yii::t('app', 'Create'), 'url' => Url::to(['/admin/page/create']), 'active' => true],
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
        'slug',
        [
            'attribute' => 'name',
            'format' => 'text',
        ],
        [
            'attribute' => 'is_system',
            'filter' => EntityDropDown::widget([
                'model' => $searchModel,
                'attribute' => 'is_system',
                'items' => [Yii::t('app', 'No'), Yii::t('app', 'Yes')],
            ]),
            'value' => function($data) {
                return $data->is_system ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            }
        ],
        [
            'attribute' => 'status',
            'filter' => EntityDropDown::widget([
                'model' => $searchModel,
                'attribute' => 'status',
                'items' => [Yii::t('app', 'No'), Yii::t('app', 'Yes')],
            ]),
            'value' => function($data) {
                return $data->status ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function ($url) {
                    $options = array_merge([
                        'title' => Yii::t('yii', 'Update'),
                        'aria-label' => Yii::t('yii', 'Update'),
                        'data-pjax' => '0',
                    ]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                },
                'delete' => function ($url, $model) {
                    $options = array_merge([
                        'title' => Yii::t('yii', 'Delete'),
                        'aria-label' => Yii::t('yii', 'Delete'),
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ]);
                    return $model->is_system ? '' : Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                }
            ]

        ],
    ]
]);

