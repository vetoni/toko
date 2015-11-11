<?php

use app\helpers\CurrencyHelper;
use app\modules\admin\models\AddProductForm;
use app\modules\checkout\models\Order;
use app\widgets\Nav;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;

/**
 * @var Order $order
 * @var AddProductForm $newProduct
 */

$this->title = Yii::t('app', 'Order items');
$leftArrow = "<i class=\"glyphicon glyphicon-chevron-left font-12\"></i>";
$items = $order->orderLines;

echo Nav::widget([
    'encodeLabels' => false,
    'items' => [
        ['label' => "$leftArrow " . Yii::t('app', 'Order'), 'url' => Url::to(['/admin/order/update', 'id' => $order->id]), 'active' => true],
    ],
    'options' => ['class' => 'nav-pills']
]);
?>

<h3><?= Yii::t('app', 'Info') ?></h3>
<table class="table table-bordered table-striped">
    <tr>
        <th><?= Yii::t('app', 'ID') ?></th>
        <td><?= $order->id ?></td>
    </tr>
    <tr>
        <th><?= Yii::t('app', 'Total') ?></th>
        <td><?= CurrencyHelper::format($order->total, $order->currency_code, false) ?></td>
    </tr>
</table>

<h3><?= Yii::t('app', 'New product') ?></h3>
<div class="row">
    <div class="col-md-3">
    <?php
        $form = ActiveForm::begin();
        echo $form->field($newProduct, 'product_id');
        echo $form->field($newProduct, 'quantity');
        echo Html::submitButton(Yii::t('app', 'Add product'), ['class' => 'btn btn-success']);
        ActiveForm::end();
    ?>
    </div>
</div>

<h3><?= Yii::t('app', 'Items') ?></h3>
<?php
$dataProvider = new ArrayDataProvider([
    'key' => 'id',
    'allModels' => $items
]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'product_id',
        [
          'label' => Yii::t('app', 'Name'),
          'format' => 'html',
          'value' => function($line) {
              return Html::a($line->product->name, ['/admin/product/update', 'id' => $line->product->id]);
          }
        ],
        'quantity',
        [
            'attribute' => 'price',
            'value' => function($line) use ($order) {
                return CurrencyHelper::format($line->price, $order->currency_code, false);
            }
        ],
        [
            'attribute' => 'subtotal',
            'value' => function($line) use ($order) {
                return CurrencyHelper::format($line->subtotal, $order->currency_code, false);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
        ],
    ]
]);
?>