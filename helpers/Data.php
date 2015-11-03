<?php

namespace app\helpers;

use Yii;

/**
 * Class Data
 * @package app\helpers
 */
class Data
{
    /**
     * @param $key
     * @param $callable
     * @param int $duration
     * @return mixed
     */
    public static function cache($key, $callable, $duration = 3600)
    {
        $cache = Yii::$app->cache;
        if($cache->exists($key)){
            $data = $cache->get($key);
        }
        else{
            $data = $callable();

            if($data !== false) {
                $cache->set($key, $data, $duration);
            }
        }
        return $data;
    }
}