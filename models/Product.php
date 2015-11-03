<?php

namespace app\models;

use app\components\ActiveRecord;
use app\behaviors\RelatedItemsBehavior;
use app\modules\file\behaviors\ImageAttachmentBehavior;
use app\modules\file\models\Image;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Class Product
 * @package app\models
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $slug
 * @property string $announce
 * @property string $description
 * @property double $old_price
 * @property double $price
 * @property integer $inventory
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property Category category
 * @property Image[] $images
 * @property string $imageUrl
 * @property Product[] $related
 */
class Product extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'slug'], 'required'],
            ['category_id', 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['announce', 'description'], 'string'],
            [['old_price', 'price'], 'double'],
            [['old_price', 'price'], 'compare', 'compareValue' => 0, 'operator' => '>='],
            [['price', 'inventory'], 'default', 'value' => 0],
            ['status', 'integer'],
            ['status', 'default', 'value' => 1],
            ['relationInfo', 'safe']
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
            ],
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique' => true
            ],
            [
                'class' => ImageAttachmentBehavior::className()
            ],
            [
                'class' => RelatedItemsBehavior::className(),
                'relatedModelClass' => static::className()
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return float
     */
    public function getRating()
    {
        return 4.5;
    }
}