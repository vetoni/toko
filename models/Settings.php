<?php

namespace app\models;

use app\components\ActiveRecord;
use yii\base\InvalidParamException;


/**
 * Class Settings
 * @package app\models
 *
 * @property int $id
 * @property string $group
 * @property string $name
 * @property string $value
 */
class Settings extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    /**
     * @param $group
     * @param $name
     * @return $this
     */
    public static function value($group, $name)
    {
        $rec = static::get($group, $name);

        if (!isset($rec)) {
            throw new InvalidParamException("Can not load settings group='$group', name='$name'.");
        }

        return isset($rec) ? $rec->value : null;
    }

    /**
     * @param $group
     * @param $name
     * @return $this
     */
    public static function get($group, $name)
    {
        return static::findOne(['group' => $group, 'name' => $name]);
    }
}