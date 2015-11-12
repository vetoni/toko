<?php

namespace app\modules\checkout\models;

use yii\base\Model;

/**
 * Class AddToWishListForm
 * @package app\modules\checkout\models
 */
class AddToWishListForm extends Model
{
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
            ['productId', 'integer'],
        ];
    }
}