<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%currency}}".
 *
 * @property string $name
 * @property string $code
 * @property string $is_default
 * @property double $rate
 * @property string $symbol
 */
class Currency extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%currency}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code', 'is_default', 'rate', 'symbol'], 'required'],
            [['is_default'], 'integer'],
            [['rate'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['code', 'symbol'], 'string', 'max' => 10],
            [['code'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'is_default' => Yii::t('app', 'Is Default'),
            'rate' => Yii::t('app', 'Rate'),
            'symbol' => Yii::t('app', 'Symbol'),
        ];
    }
}
