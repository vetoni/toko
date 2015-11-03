<?php

namespace app\models;

use app\components\ActiveRecord;
use app\modules\file\behaviors\ImageAttachmentBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Class Page
 * @package app\models
 *
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property string $slug
 * @property string $announce
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property string $imageUrl
 * @property boolean $is_system
 */
class Page extends ActiveRecord
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['type', 'name', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['announce', 'content', 'type'], 'string'],
            ['status', 'integer'],
            ['status', 'default', 'value' => 1],
            ['is_system', 'default', 'value' => 0],
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
        ];
    }
}