<?php

namespace app\models;

use app\components\ActiveRecord;
use app\modules\user\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property string $id
 * @property string $product_id
 * @property string $user_id
 * @property string $rating
 * @property string $body
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 * @property Product $product
 * @property User $user
 */
class Comment extends ActiveRecord
{
    /**
     * Inactive comment status
     */
    const STATUS_INACTIVE = 0;

    /**
     * Inactive comment status
     */
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['body'], 'required'],
            [['product_id', 'user_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['body'], 'string'],
            ['status', 'default', 'value' => 1],
            ['rating', 'number'],
            ['rating', 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'user_id' => Yii::t('app', 'User'),
            'rating' => Yii::t('app', 'Rating'),
            'body' => Yii::t('app', 'Body'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @inheritdoc
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
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
