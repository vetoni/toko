<?php

namespace app\components;

/**
 * Class ActiveRecord
 * @package app\components
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * @return ActiveQuery
     */
    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }
}