<?php

namespace app\modules\checkout\models;

use app\api\Catalog;
use app\helpers\Data;
use yii\base\InvalidParamException;
use yii\base\Model;

/**
 * Class Cart
 * @package app\modules\checkout\models
 *
 * @property float $total
 * @property float $totalExclDiscount
 * @property float $discount
 * @property integer $totalCount
 */
class Cart extends Model
{
    /**
     * @var CartLine[]
     */
    public $lines = [];

    /**
     * @var float
     */
    public $discount = 0;

    /**
     * @param $productId
     * @param int $quantity
     */
    public function add($productId, $quantity = 1)
    {
        if (isset($this->lines[$productId])) {
            $this->lines[$productId]->quantity += $quantity;
        }
        else {
            $product = Catalog::product($productId);
            if (!$product) {
                throw new InvalidParamException("Product with id = {$productId} does not exist");
            }
            $this->lines[$productId] = new CartLine(['product_id' => $productId, 'price' => $product->model->price, 'quantity' => $quantity]);
        }
        $this->save();
    }

    /**
     * @param $productId
     */
    public function remove($productId)
    {
        if (isset($this->lines[$productId])) {
            unset($this->lines[$productId]);
            $this->save();
        }
    }

    /**
     * Clears cart lines
     */
    public function clear()
    {
        $this->lines = [];
        $this->save();
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        $count = 0;
        foreach ($this->lines as $line)
        {
            $count += $line->quantity;
        }
        return $count;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        if ($this->discount > 0)
        {
            return $this->totalExclDiscount * (1 - $this->discount);
        }
        return $this->totalExclDiscount;
    }

    /**
     * @return float
     */
    public function getTotalExclDiscount()
    {
        $subTotal = 0;
        foreach ($this->lines as $line)
        {
            $subTotal += $line->subtotal;
        }
        return $subTotal;
    }

    /**
     * @param $id
     * @return bool
     */
    public function hasLine($id)
    {
        return isset($this->lines[$id]);
    }

    /**
     * Normalize cart. Removes lines with not existing product etc.
     */
    public function normalize()
    {
        foreach ($this->lines as $line)
        {
            if (!$line->product) {
                $this->remove($line->product_id);
            }
        }
    }

    /**
     * Gets shopping cart
     * @return static
     */
    public static function get()
    {
        return Data::load('shopping_cart', function() {
            return new static();
        });
    }

    /**
     * Saves cart
     */
    public function save()
    {
        Data::save('shopping_cart', $this);
    }
}