<?php

namespace app\components;

use yii\base\Object;

/**
 * Class Api
 * @package app\components
 */
class Api extends Object
{
    /**
     * @var array
     */
    public static $instances = [];

    /**
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        $key = static::className();
        if (!isset(self::$instances[$key])) {
            self::$instances[$key] = new static();
        }
        return call_user_func_array([self::$instances[$key], "api_$method"], $parameters);
    }

    /**
     * @param $params
     * @return string
     */
    public function makeCacheKey($params = [])
    {
        if (!is_array($params)) {
            $params = [$params];
        }
        return implode('_',array_merge([__CLASS__, __METHOD__], $params));
    }
}