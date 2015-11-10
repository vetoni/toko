<?php

namespace app\helpers;

use app\models\UserData;
use Yii;

/**
 * Class Data
 * @package app\helpers
 */
class Data
{
    /**
     * @var UserData[]
     */
    protected static $_records;

    /**
     * Loads data from database if user is logged in.
     * Otherwise loads from session.
     * @param $name
     * @param callable $callback
     * @return mixed
     */
    public static function load($name, callable $callback = null)
    {
        $key = self::_sessionKey($name);
        $data = Yii::$app->session->get($key);

        if (!Yii::$app->user->isGuest) {
            $rec = static::findRecord($name);
            if ($rec) {
                $data = $rec->data;
            }
            // Ensures data will be removed from session after user log out
            Yii::$app->session->remove($key);
        }

        if (isset($data)) {
            return unserialize($data);
        }
        else {
            return static::save($name, is_callable($callback) ? $callback() : null);
        }
    }

    /**
     * Saves data to database if user is logged in.
     * Otherwise saves data into session.
     * @param $name
     * @param $data
     */
    public static function save($name, $data)
    {
        $str = serialize($data);
        if (!Yii::$app->user->isGuest) {
            self::updateRecord($name, $str);
        }
        else {
            $key = self::_sessionKey($name);
            Yii::$app->session->set($key, $str);
        }
        return $data;
    }

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

    /**
     * @param $name
     * @return string
     */
    protected static function _sessionKey($name)
    {
        return "user_data:$name";
    }

    /**
     * @param $name
     * @param $data
     */
    protected static function updateRecord($name, $data)
    {
        $rec = static::findRecord($name);
        if (!$rec) {
            $rec = new UserData();
            $rec->user_id = Yii::$app->user->getId();
            $rec->name = $name;
        }
        $rec->data = $data;
        $rec->save();
        static::$_records[$name] = $rec;
    }

    /**
     * @param $name
     * @return UserData
     */
    protected static function findRecord($name)
    {
        if (!isset(static::$_records[$name])) {
            static::$_records[$name] = UserData::findOne(['user_id' => Yii::$app->user->getId(), 'name' => $name]);
        }
        return static::$_records[$name];
    }
}