<?php

namespace app\modules\checkout\models;

use app\helpers\Data;
use yii\base\Model;

/**
 * Class OrderAddress
 * @package app\modules\checkout\models
 */
class OrderAddress extends Model
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $country_id;

    /**
     * @var string
     */
    public $address;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $comment;

    public function rules()
    {
        return [
            [['name', 'country_id', 'address', 'phone'], 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => '255'],
            ['name', 'string', 'max' => '255'],
            ['country_id', 'string', 'max' => '10'],
            ['address', 'string', 'max' => '255'],
            ['phone', 'string', 'max' => '255'],
            ['comment', 'string', 'max' => 4000],
            ['comment', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => \Yii::t('app', 'Name'),
            'country_id' => \Yii::t('app', 'Country'),
            'address' => \Yii::t('app', 'Address'),
            'email' => \Yii::t('app', 'Email'),
            'phone' => \Yii::t('app', 'Phone'),
            'comment' => \Yii::t('app', 'Comment'),
        ];
    }

    /**
     * Gets order address
     * @return static
     */
    public static function get()
    {
        return Data::load('order_address', function() {
            return new static();
        });
    }

    /**
     * Saves order address
     */
    public function save()
    {
        Data::save('order_address', $this);
    }
}