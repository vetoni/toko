<?php

use app\modules\admin\widgets\Menu;

echo Menu::widget([
   'items' => [
       [
           'class' => 'active',
           'url' => ['/admin/dashboard/index'],
           'label' => '<i class="glyphicon glyphicon-dashboard"></i> ' . Yii::t('app', 'Dashboard'),
           'scope' => ['dashboard']
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
           'label' => '<i class="glyphicon glyphicon-file"></i> ' . Yii::t('app', 'Pages'),
           'scope' => ['page']
       ],
       [
           'class' => 'active',
           'url' => ['/admin/currency/list'],
           'label' => '<i class="glyphicon glyphicon-rub"></i> ' . Yii::t('app', 'Currencies'),
           'scope' => ['currency']
       ],
   ],
   'encodeLabels' => false,
   'options' => [
       'class' => 'sidebar-nav'
   ]
]);

