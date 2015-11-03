<?php

namespace app\widgets;

class Nav extends \yii\bootstrap\Nav
{
    /**
     * @param array $item
     * @return bool
     */
    protected function isItemActive($item)
    {
        return (isset($item['scope']))
            ? in_array(\Yii::$app->controller->id, $item['scope'])
            : parent::isItemActive($item);
    }
}