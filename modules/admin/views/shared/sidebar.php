<?php

use app\modules\admin\widgets\Menu;

echo Menu::widget([
   'items' => [
       [
           'class' => 'active',
           'url' => ['/admin/dashboard/index'],
           'label' => '<i class="glyphicon glyphicon-dashboard"></i> ' . Yii::t('app', 'Dashboard'),
       ],
       [
           'class' => 'active',
           'url' => ['/admin/category/list'],
           'label' => '<i class="glyphicon glyphicon-align-justify"></i> ' . Yii::t('app', 'Catalog'),
           'scope' => ['category', 'product']
       ],
       [
           'class' => 'active',
           'url' => ['/admin/page/list'],
           'label' => '<i class="glyphicon glyphicon glyphicon-file"></i> ' . Yii::t('app', 'Pages'),
           'scope' => ['page']
       ],
   ],
   'encodeLabels' => false,
   'options' => [
       'class' => 'sidebar-nav'
   ]
]);

