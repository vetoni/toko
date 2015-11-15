<?php

use app\modules\admin\models\PageSearch;
use app\modules\user\models\User;
use app\widgets\EntityDropDown;
use yii\bootstrap\Nav;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * @var PageSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('app', 'News items');

echo Nav::widget([
    'encodeLabels' => false,
    'items' => [
        ['label' => Yii::t('app', 'Create'), 'url' => Url::to(['create']), 'active' => true],
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
            'attribute' => 'author_id',
            'format' => 'html',
            'filter' => EntityDropDown::widget([
                'model' => $searchModel,
                'attribute' => 'author_id',
                'items' => ArrayHelper::map(User::find()->all(), 'id', 'name'),
            ]),
            'value' => function($newsItem) {
                return User::findOne($newsItem->author_id)->name;
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
        ],
    ]
]);

