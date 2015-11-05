<?php

namespace app\components;

use yii\base\Object;

/**
 * Class ApiObject
 * @package app\components
 */
class ApiObject extends Object
{
    /** @var \yii\base\Model  */
    public $model;

    /**
     * Generates ApiObject, attaching all settable properties to the child object
     * @param \yii\base\Model $model
     */
    public function __construct($model)
    {
        return parent::__construct(['model' => $model]);
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \yii\base\UnknownPropertyException
     */
    public function __get($name)
    {
        if ($this->canGetProperty($name)) {
            return parent::__get($name);
        }
        else {
            return $this->model->{$name};
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     * @throws \yii\base\UnknownPropertyException
     */
    public function __set($name, $value)
    {
        if ($this->canSetProperty($name)) {
            parent::__set($name, $value);
        }
        else {
            $this->model->$name = $value;
        }
    }

    /**
     * @param string $name
     * @param array $params
     * @return mixed
     * @throws \yii\base\UnknownPropertyException
     */
    public function __call($name, $params)
    {
        if (method_exists($this->model, $name)) {
            return call_user_func_array([$this->model, $name], $params);
        }
        foreach ($this->model->behaviors as $behavior) {
            if (method_exists($behavior, $name)) {
                return call_user_func_array([$this->model, $name], $params);
            }
        }
        return parent::__get($name);
    }
}