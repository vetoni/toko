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
           'url' => ['/admin/order/list'],
           'label' => '<i class="glyphicon glyphicon-th-list"></i> ' . Yii::t('app', 'Orders'),
           'scope' => ['order', 'order-items']
       ],
       [
           'class' => 'active',
           'url' => ['/admin/comment/list'],
           'label' => '<i class="glyphicon glyphicon-comment"></i> ' . Yii::t('app', 'Comments'),
           'scope' => ['comment']
       ],
       [
           'class' => 'active',
           'url' => ['/admin/news-items/list'],
           'label' => '<i class="glyphicon glyphicon-list-alt"></i> ' . Yii::t('app', 'News'),
           'scope' => ['news-items']
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

