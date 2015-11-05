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
     * @var array
     */
    protected static $_items;

    /**
     * Loads data from database if user is logged in.
     * Otherwise loads from session.
     * @param $name
     * @return mixed
     */
    public static function load($name)
    {
        if (!isset(static::$_items[$name])) {
            $key = self::_getSessionKey($name);
            $data = Yii::$app->session->get($key);

            if (!Yii::$app->user->isGuest) {
                /** @var UserData $rec */
                $rec = UserData::findOne(['user_id' => Yii::$app->user->getId(), 'name' => $name]);
                if ($rec) {
                    $data = $rec->data;
                } else {
                    self::_save($name, $data);
                }
                Yii::$app->session->remove($key);
            }
            static::$_items[$name] = isset($data) ? unserialize($data) : null;
        }
        return static::$_items[$name];
    }

    /**
     * Saves data to database if user is logged in.
     * Otherwise saves data into session.
     * @param $name
     * @param $data
     */
    public static function save($name, $data)
    {
        static::$_items[$name] = $data;
        $data = serialize($data);
        if (!Yii::$app->user->isGuest) {
            self::_save($name, $data);
        }
        else {
            $key = self::_getSessionKey($name);
            Yii::$app->session->set($key, $data);
        }
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
    protected static function _getSessionKey($name)
    {
        return "user_data:$name";
    }

    /**
     * @param $name
     * @param $data
     */
    protected static function _save($name, $data)
    {
        /** @var UserData $rec */
        $uid = Yii::$app->user->getId();
        $rec = UserData::findOne(['user_id' => $uid]);
        if (!$rec) {
            $rec = new UserData();
            $rec->user_id = $uid;
            $rec->name = $name;
        }
        $rec->data = $data;
        $rec->save();
    }
}