<?php

namespace app\modules\checkout\models;

use app\api\Catalog;
use app\models\Product;
use yii\base\Model;

/**
 * Class CartLine
 * @package app\modules\checkout\models
 *
 * @property double $subtotal
 * @property Product $product
 */
class CartLine extends Model
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['quantity', 'required'],
            ['quantity', 'integer', 'min' => 0, 'max' => 9999],
            [['product_id', 'price'], 'safe'],
        ];
    }

    /**
     * @var string
     */
    public $product_id;

    /**
     * @var integer
     */
    public $quantity;

    /**
     * @var float
     */
    public $price;

    /**
     * @return mixed
     */
    public function getSubtotal()
    {
        return $this->quantity * $this->price;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return Catalog::product($this->product_id);
    }
}