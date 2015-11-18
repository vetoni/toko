<?php

namespace app\models;

use app\behaviors\RelatedItemsBehavior;
use app\components\ActiveRecord;
use app\components\ProductQuery;
use app\modules\file\behaviors\ImageAttachmentBehavior;
use app\modules\file\models\Image;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property string $id
 * @property string $category_id
 * @property string $name
 * @property string $slug
 * @property string $announce
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 * @property string $old_price
 * @property string $price
 * @property integer $inventory
 * @property Category $category
 * @property Image[] $images
 * @property Comment[] $comments
 * @method ProductQuery withRelatedItems()
 */
class Product extends ActiveRecord
{
    /**
     * @var double
     */
    public $rating;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * @return ProductQuery
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'slug'], 'required'],
            [['category_id', 'created_at', 'updated_at', 'status', 'inventory'], 'integer'],
            [['announce', 'description'], 'string'],
            [['old_price', 'price'], 'number'],
            [['old_price', 'price'], 'compare', 'compareValue' => 0, 'operator' => '>='],
            [['price', 'inventory'], 'default', 'value' => 0],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            ['status', 'default', 'value' => 1],
            ['related', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'announce' => Yii::t('app', 'Announce'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'status' => Yii::t('app', 'Status'),
            'old_price' => Yii::t('app', 'Old Price'),
            'price' => Yii::t('app', 'Price'),
            'inventory' => Yii::t('app', 'Inventory'),
            'rating' => Yii::t('app', 'Rating')
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
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['product_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);
    }
}
