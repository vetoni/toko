<?php

namespace app\modules\admin\widgets;

/**
 * Class Menu
 * @package app\modules\admin\widgets
 */
class Menu extends \yii\widgets\Menu
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