<?php

namespace app\widgets;

use app\models\Settings;
use yii\base\Widget;

/**
 * Class StockIndicator
 * @package app\widgets
 */
class StockIndicator extends Widget
{
    /**
     * @var
     */
    public $inventory;

    /**
     * @return string
     */
    public function run()
    {
        if ($this->inventory <= Settings::value('stock', 'outofstock')) {
            return '<span class="out-of-stock">' . \Yii::t('app', 'Out of stock') . '</span>';
        } elseif ($this->inventory <= Settings::value('stock', 'lowstock')) {
            return '<span class="low-stock">' . \Yii::t('app', 'Low stock') . '</span>';
        }
        return '<span class="in-stock">' . \Yii::t('app', 'In stock') . '</span>';
    }
}