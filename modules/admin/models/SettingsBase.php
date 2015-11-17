<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use app\models\Settings;

/**
 * Class SettingsBase
 * @package app\modules\admin\models
 */
class SettingsBase extends Model
{
    /**
     * @var
     */
    protected $_attributes;

    /**
     * @param string $name
     * @return $this|mixed
     * @throws \yii\base\UnknownPropertyException
     */
    public function __get($name)
    {
        if (isset($this->_attributes[$name])) {
            return $this->_attributes[$name];
        }

        $_name = explode('.', $name);
        if (count($_name) == 2) {
            return Settings::value($_name[0], $_name[1]);
        }
        return parent::__get($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $_name = explode('.', $name);
        if (count($_name) == 2) {
            $this->_attributes[$name] = $value;
        }
        else {
            parent::__set($name, $value);
        }
    }

    /**
     * Saves settings.
     */
    public function save()
    {
        foreach ($this->_attributes as $name => $value) {
            $_name = explode('.', $name);
            $settings = Settings::get($_name[0], $_name[1]);
            $settings->value = $value;
            $settings->save();
        }
    }
}