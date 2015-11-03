<?php

namespace app\api;

use app\components\ApiObject;
use app\models\Product;
use app\modules\file\models\Image;

/**
 * Class ProductObject
 * @package app\api
 *
 * @property Product $model
 * @method string thumb(integer $width, integer $height)
 */
class ProductObject extends ApiObject
{
    /**
     * @var Product[]
     */
    protected $_related;

    /**
     * @var Image[]
     */
    protected $_images;

    /**
     * @return ProductObject[]
     */
    public function related()
    {
        if (!isset($this->_related)) {
            foreach ($this->model->related as $product) {
                $this->_related[] = new static($product);
            }
        }
        return $this->_related;
    }
}