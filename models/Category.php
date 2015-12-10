<?php

namespace app\models;

use app\modules\file\behaviors\ImageAttachmentBehavior;
use kartik\tree\models\Tree;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property string $slug
 * @property string $announce
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 * @property Product[] $products
 * @method boolean isLeaf()
 * @method ActiveQuery children($depth = null)
 * @method ActiveQuery parents($depth = null)
 * @method ActiveQuery roots()
 */
class Category extends Tree
{
    /**
     * @var bool
     */
    public $encodeNodeNames = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['announce', 'description'], 'string'],
            ['status', 'default', 'value' => 1],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'announce' => Yii::t('app', 'Announce'),
            'description' => Yii::t('app', 'Description'),
            'image' => Yii::t('app', 'Image'),
            'status' => Yii::t('app', 'Published'),
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique' => true
            ],
            [
                'class' => TimestampBehavior::className(),
            ],
            [
                'class' => ImageAttachmentBehavior::className()
            ],
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }
}
