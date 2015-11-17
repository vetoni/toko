<?php

namespace app\modules\admin\models;

/**
 * Class GeneralSettings
 * @package app\modules\admin\models
 */
class GeneralSettings extends SettingsBase
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['stock.lowstock', 'stock.outofstock'], 'required'],
            [['stock.lowstock', 'stock.outofstock'], 'integer'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'stock.lowstock' => \Yii::t('app', 'Low stock'),
            'stock.outofstock' => \Yii::t('app', 'Out of stock'),
        ];
    }
}