<?php

namespace app\modules\admin\models;

use app\models\Product;
use yii\base\Model;

/**
 * Class AddProductForm
 * @package app\modules\admin\models
 */
class AddProductForm extends Model
{
    /**
     * @var integer
     */
    public $product_id;

    /**
     * @var integer
     */
    public $quantity;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['product_id', 'quantity'], 'required'],
            [['product_id'], 'validateProduct'],
            [['quantity', 'product_id'], 'integer', 'min' => 1],
        ];
    }

    /**
     * Validates product
     */
    public function validateProduct()
    {
        if (!Product::findOne($this->product_id)) {
            $this->addError('product_id', \Yii::t('app', 'Product does not exist.'));
        }
    }
}