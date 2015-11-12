<?php

namespace app\modules\checkout\models;

use app\api\Catalog;
use app\helpers\Data;
use yii\base\Model;

/**
 * Class WishList
 * @package app\modules\checkout\models
 */
class WishList extends Model
{
    /**
     * @var array
     */
    public $items = [];

    /**
     * @param $product_id
     */
    public function add($product_id)
    {
        $product = Catalog::product($product_id);
        if ($product) {
            $this->items[$product_id] = ['name' => $product->model->name];
        }
        $this->save();
    }

    /**
     * @param $product_id
     */
    public function remove($product_id)
    {
        if (isset($this->items[$product_id])) {
            unset($this->items[$product_id]);
        }
        $this->save();
    }

    /**
     * @param $product_id
     * @return bool
     */
    public function has($product_id)
    {
        return array_key_exists($product_id, $this->items);
    }

    /**
     * Gets wish list
     * @return static
     */
    public static function get()
    {
        return Data::load('wish_list', function() {
            return new static();
        });
    }

    /**
     * Saves wish list
     */
    public function save()
    {
        Data::save('wish_list', $this);
    }
}