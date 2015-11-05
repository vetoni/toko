<?php

namespace app\models;

use app\components\ActiveRecord;
use app\modules\file\behaviors\ImageAttachmentBehavior;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property string $id
 * @property string $type
 * @property string $name
 * @property string $slug
 * @property string $announce
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 * @property string $is_system
 */
class Page extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'name', 'slug'], 'required'],
            [['announce', 'content'], 'string'],
            [['created_at', 'updated_at', 'status', 'is_system'], 'integer'],
            [['type'], 'string', 'max' => 45],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            ['status', 'default', 'value' => 1],
            ['is_system', 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'announce' => Yii::t('app', 'Announce'),
            'content' => Yii::t('app', 'Content'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'status' => Yii::t('app', 'Status'),
            'is_system' => Yii::t('app', 'Is System')
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
