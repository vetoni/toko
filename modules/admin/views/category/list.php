<?php

use app\models\Category;
use kartik\tree\TreeView;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var integer $node
 */

$this->title = Yii::t('app', 'Categories');

$id = 'category_tree';

echo TreeView::widget([
    'id' => $id,
    'query' => Category::find()->addOrderBy('root, lft'),
    'isAdmin' => false,
    'displayValue' => $node,
    'iconEditSettings' => [
        'show' => 'none',
        'listData' => []
    ],
    'wrapperTemplate' =>  "{tree}{footer}",
    'defaultChildNodeIcon' => '<i class="glyphicon glyphicon-folder-close"></i>',
    'softDelete' => false,
    'nodeFormOptions' => ['enctype' => 'multipart/form-data'],
    'nodeAddlViews' => [
        \kartik\tree\Module::VIEW_PART_2 => '@app/modules/admin/views/category/details'],
    'rootOptions' => [
        'label' => Yii::t('app', 'Shop')
    ],
]);

$listUrl = Url::to(['/admin/category/list']);
$this->registerJs(new \yii\web\JsExpression(<<<EOD
$("#$id").on('treeview.selected', function(event, key, data, textStatus, jqXHR) {
    if (key) window.history.pushState(key, 'key', '{$listUrl}?node=' + (key));
});
EOD
));