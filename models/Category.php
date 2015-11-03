<?php

namespace app\models;

use app\modules\file\behaviors\ImageAttachmentBehavior;
use app\modules\file\models\Image;
use kartik\tree\models\Tree;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Class Category
 * @package app\models
 *
 * @property string $slug
 * @property string $announce
 * @property string $description
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 * @property Image $image
 * @property string $imageUrl
 */
class Category extends Tree
{
    /**
     * @var bool
     */
    public $encodeNodeNames = false;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        $rules =  array_merge(parent::rules(), [
            [['announce', 'description'], 'string'],
            ['status', 'default', 'value' => 1],
        ]);

        return $rules;
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