<?php

use app\models\Category;
use app\modules\admin\models\ProductSearch;
use app\widgets\EntityDropDown;
use yii\bootstrap\Nav;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;

/**
 * @var ProductSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 * @var Category $category
 */

$this->title = Yii::t('app', 'Products');
$leftArrow = "<i class=\"glyphicon glyphicon-chevron-left font-12\"></i>";

echo Nav::widget([
    'encodeLabels' => false,
    'items' => [
        ['label' => "$leftArrow " . Yii::t('app', 'Categories'), 'url' => Url::to(['/admin/category/list', 'node' => $category->id])],
        ['label' => $category->name, 'url' => Url::to(), 'active' => true],
        ['label' => Yii::t('app', 'Create'), 'url' => Url::to(['/admin/product/create', 'node' => $category->id])],
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
        'price',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
        ],
    ]
]);

