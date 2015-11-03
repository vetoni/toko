<?php


namespace app\modules\user;

use yii\base\Module;

/**
 * Class UserModule
 * @package app\modules\user
 */
class UserModule extends Module
{
    /**
     * @var int
     */
    public $userLoginDuration = 3600*24*30;

    /**
     * @var int
     */
    public $passwordResetTokenExpire = 3600;
}