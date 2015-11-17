<?php

namespace app\modules\install\models;

use yii\base\Model;

/**
 * Class Configuration
 * @package app\modules\install\models
 */
class Configuration extends Model
{
    /**
     * @var
     */
    public $shopEmail;

    /**
     * @var
     */
    public $adminEmail;

    /**
     * @var
     */
    public $adminPassword;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['shopEmail', 'adminEmail', 'adminPassword'], 'required'],
            [['shopEmail', 'adminEmail'], 'string', 'max' => 255],
            [['shopEmail', 'adminEmail'], 'email'],
            ['adminPassword', 'string', 'min' => 4, 'max' => 20],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'shopEmail' => \Yii::t('app', 'Shop email'),
            'adminEmail' => \Yii::t('app', 'Admin email'),
            'adminPassword' => \Yii::t('app', 'Admin password'),
        ];
    }
}