<?php

namespace app\modules\checkout\models;

use yii\base\Model;

/**
 * Class AddToCartForm
 * @package app\modules\checkout\models
 */
class AddToCartForm extends Model
{
    /**
     * @var integer
     */
    public $quantity;

    /**
     * @var string
     */
    public $productId;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['quantity', 'required', 'message' => ''],
            ['quantity', 'integer', 'min' => 1],
            ['productId', 'integer'],
        ];
    }
}