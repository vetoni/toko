<?php

use app\models\Comment;
use app\models\Product;
use app\modules\admin\models\CommentSearch;
use app\modules\user\models\User;
use app\widgets\EntityDropDown;
use app\widgets\Rating;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\View;

/**
 * @var CommentSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 * @var View $this
 */

$this->title = Yii::t('app', 'Comments');
?>

<?php

echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [

        [
            'attribute' => 'product_id',
            'filter' => false,
            'format' => 'text',
        ],

        [
            'label' => Yii::t('app', 'Product name'),
            'filter' => false,
            'format' => 'html',
            'value' => function($comment) {
                /** @var Product $product */
                $product = Product::findOne($comment->product_id);
                return Html::a($product->name, ['/admin/product/update', 'id' => $product->id]);
            }
        ],

        [
            'attribute' => 'user_id',
            'format' => 'html',
            'filter' => EntityDropDown::widget([
                'model' => $searchModel,
                'attribute' => 'user_id',
                'items' => ArrayHelper::map(User::find()->all(), 'id', 'name'),
            ]),
            'value' => function($comment) {
                return User::findOne($comment->user_id)->name;
            }
        ],

        [
            'attribute' => 'body',
            'format' => 'text',
            'value' => function($comment) {
                return \yii\helpers\StringHelper::truncateWords($comment->body, 10);
            }
        ],

        'created_at:datetime',

        [
            'attribute' => 'rating',
            'format' => 'raw',
            'filter' => false,
            'value' => function($comment) {
                return Rating::widget(['readonly' => true, 'name' => "rating[{$comment->id}]", 'value' => $comment->rating]);
            }
        ],

        [
            'attribute' => 'status',
            'format' => 'html',
            'filter' => EntityDropDown::widget([
                'model' => $searchModel,
                'attribute' => 'user_id',
                'items' => [Yii::t('app', 'Inactive'), Yii::t('app', 'Active')],
            ]),
            'value' => function($comment) {
                return $comment->status == Comment::STATUS_ACTIVE ? Yii::t('app', 'Active') : Yii::t('app', 'Inactive');
            }
        ],

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
        ],

    ]
]);

?>
