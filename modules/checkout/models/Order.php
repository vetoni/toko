<?php

namespace app\modules\checkout\models;

use app\components\ActiveRecord;
use app\models\Currency;
use app\modules\user\models\Country;
use app\modules\user\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $currency_code
 * @property float $discount
 * @property string $name
 * @property string $country_id
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property string $comment
 * @property string $token
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property Country $country
 * @property Currency $currencyCode
 * @property User $user
 * @property OrderData[] $orderLines
 * @property float $total
 * @property float $totalExclDiscount
 */
class Order extends ActiveRecord
{
    /**
     * Status is assigned when order created
     */
    const STATUS_NEW = 0;

    /**
     * Status is assigned when order is closed
     */
    const STATUS_CLOSED = 1;

    /**
     * Status is assigned when order is canceled
     */
    const STATUS_CANCELED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['currency_code', 'name', 'country_id', 'address', 'phone', 'token', 'status'], 'required'],
            [['discount'], 'number', 'min' => 0, 'max' => 1],
            [['currency_code', 'country_id'], 'string', 'max' => 10],
            [['name', 'address', 'phone', 'email', 'comment', 'token'], 'string', 'max' => 255],
            ['email', 'email']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User account'),
            'currency_code' => Yii::t('app', 'Currency'),
            'discount' => Yii::t('app', 'Discount'),
            'name' => Yii::t('app', 'Name'),
            'country_id' => Yii::t('app', 'Country'),
            'address' => Yii::t('app', 'Address'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'comment' => Yii::t('app', 'Comment'),
            'token' => Yii::t('app', 'Token'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className()
            ]
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->token = \Yii::$app->security->generateRandomString(32);
        }
        return parent::beforeValidate();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyCode()
    {
        return $this->hasOne(Currency::className(), ['code' => 'currency_code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderLines()
    {
        return $this->hasMany(OrderData::className(), ['order_id' => 'id']);
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
        foreach ($this->orderLines as $line)
        {
            $subTotal += $line->subtotal;
        }
        return $subTotal;
    }

    /**
     * @return string
     */
    public function getStatusText()
    {
        if ($this->status == self::STATUS_CLOSED)
            return Yii::t('app', 'Closed');
        else if ($this->status == self::STATUS_CANCELED)
            return Yii::t('app', 'Canceled');
        else
            return Yii::t('app', 'New');
    }
}
