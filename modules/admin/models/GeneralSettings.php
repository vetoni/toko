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
            [['stock.lowstock', 'stock.outofstock', 'general.shopEmail', 'general.adminEmail'], 'required'],
            [['stock.lowstock', 'stock.outofstock'], 'integer'],
            [['general.shopEmail', 'general.adminEmail'], 'string', 'max' => 255],
            [['general.shopEmail', 'general.adminEmail'], 'email'],
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
            'general.shopEmail' => \Yii::t('app', 'Shop email'),
            'general.adminEmail' => \Yii::t('app', 'Admin email'),
        ];
    }
}