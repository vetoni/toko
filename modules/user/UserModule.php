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
    public $userLoginDuration = 2592000;

    /**
     * @var int
     */
    public $passwordResetTokenExpire = 3600;
}
