<?php

namespace app\models;

use app\components\ActiveRecord;
use app\modules\file\behaviors\ImageAttachmentBehavior;
use app\modules\user\models\User;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%news_item}}".
 *
 * @property string $id
 * @property string $author_id
 * @property string $name
 * @property string $slug
 * @property string $announce
 * @property string $content
 * @property string $image_title
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 *
 * @property User $author
 */
class NewsItem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'name'], 'required'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['content', 'announce'], 'string'],
            [['name', 'slug', 'image_title'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            ['status', 'default', 'value' => 1],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!isset($this->author_id)) {
            $this->author_id = Yii::$app->user->id;
        }
        return parent::beforeSave($insert);
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'author_id' => Yii::t('app', 'Author ID'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'content' => Yii::t('app', 'Content'),
            'image_title' => Yii::t('app', 'Image Title'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }
}
