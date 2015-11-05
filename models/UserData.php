<?php

namespace app\models;

use app\components\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%user_data}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $data
 */
class UserData extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_data}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name'], 'required'],
            [['user_id'], 'integer'],
            [['data'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['user_id', 'name'], 'unique', 'targetAttribute' => ['user_id', 'name'],
                'message' => Yii::t('app', 'The combination of User ID and Name has already been taken.')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'data' => Yii::t('app', 'Data'),
        ];
    }
}
