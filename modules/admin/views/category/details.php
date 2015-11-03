<?php

/**
 * @var Category $node
 * @var ActiveForm $form
 */

use app\models\Category;
use app\modules\file\ImageSelector;
use kartik\form\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\redactor\widgets\Redactor;

echo $form->field($node, 'slug')->textInput(['readonly' => true]);

echo $form->field($node, 'image')->widget(ImageSelector::className());

echo $form->field($node, 'announce')->widget(Redactor::className());

if ($node->isLeaf() && !$node->isNewRecord) {
    echo Html::a(Yii::t('app', 'View products'), Url::to(['/admin/product/list', 'node' => $node->id]), ['class' => 'btn btn-success']);
}
