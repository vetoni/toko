<?php

namespace app\modules\checkout\models;

use app\components\ActiveRecord;
use app\models\Product;
use Yii;

/**
 * This is the model class for table "{{%order_data}}".
 *
 * @property integer $id
 * @property string $order_id
 * @property string $product_id
 * @property string $quantity
 * @property string $price
 * @property Order $order
 * @property Product $product
 * @property double $subtotal
 */
class OrderData extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_data}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'quantity', 'price'], 'required'],
            [['order_id', 'product_id', 'quantity'], 'integer'],
            [['price'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'int' => Yii::t('app', 'Int'),
            'order_id' => Yii::t('app', 'Order ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'quantity' => Yii::t('app', 'Quantity'),
            'price' => Yii::t('app', 'Price'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return double
     */
    public function getSubtotal()
    {
        return $this->price * $this->quantity;
    }
}
