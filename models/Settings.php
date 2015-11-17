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
     * @var array
     */
    protected static $_settings = [];

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
        $key = "{$group}.{$name}";
        if (!isset(static::$_settings[$key])) {
            static::$_settings[$key] = static::findOne(['group' => $group, 'name' => $name]);
        }
        return static::$_settings[$key];
    }
}