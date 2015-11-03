<?php


namespace app\modules\user\models;

use app\components\ActiveRecord;
use app\modules\file\behaviors\ImageAttachmentBehavior;
use app\modules\file\models\Image;
use app\modules\user\UserModule;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * Class User
 * @package app\user\models
 *
 * @property integer $id
 * @property string $email
 * @property string $name
 * @property string $country_id
 * @property string $address
 * @property string $phone
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property int $status
 * @property Image $image
 * @property int $created_at
 * @property int $updated_at
 * @property int $role
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * Inactive user state
     */
    const USER_STATUS_INACTIVE = 0;

    /**
     * Active user state
     */
    const USER_STATUS_ACTIVE = 1;

    /**
     * Default user role
     */
    const USER_ROLE_DEFAULT = 1;

    /**
     * Admin user role
     */
    const USER_ROLE_ADMIN = 2;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'country_id', 'address', 'phone'], 'required'],
            ['name', 'string', 'max' => '255'],
            ['country_id', 'string', 'max' => '10'],
            ['address', 'string', 'max' => '255'],
            ['phone', 'string', 'max' => '255'],
            ['role', 'integer'],
            ['role', 'default', 'value' => self::USER_ROLE_DEFAULT]
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className()
            ],
            [
                'class' => ImageAttachmentBehavior::className(),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'Id'),
            'name' => \Yii::t('app', 'Name'),
            'country_id' => \Yii::t('app', 'Country'),
            'address' => \Yii::t('app', 'Address'),
            'phone' => \Yii::t('app', 'Phone'),
            'image' => \Yii::t('app', 'Photo'),
        ];
    }

    /**
     * @param int|string $id
     * @return null|User
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => static::USER_STATUS_ACTIVE]);
    }

    /**
     * @param $email
     * @return null|User
     */
    public static function findIdentityByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => static::USER_STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @param $token
     * @return null|User
     */
    public static function findIdentityByPasswordResetToken($token)
    {
        $expire = static::getModule()->passwordResetTokenExpire;
        $parts = explode('_', $token);
        $timeStamp = (int) end($parts);

        if ($timeStamp + $expire < time()) {
            return null;
        }
        return static::findOne(['password_reset_token' => $token]);
    }


    /**
     * @return string
     */
    public static function generatePasswordResetToken()
    {
        return \Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * @param $password
     * @return string
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function hashPassword($password)
    {
        return \Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @param $email
     * @param $remember_me
     * @return bool
     */
    public static function login($email, $remember_me)
    {
        return \Yii::$app->user->login(User::findIdentityByEmail($email),
            $remember_me ? static::getModule()->userLoginDuration : 0);
    }

    /**
     * @param bool $active
     */
    public function activate($active = true)
    {
        $this->status = $active ? self::USER_STATUS_ACTIVE : self::USER_STATUS_INACTIVE;
        $this->save();
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role == self::USER_ROLE_ADMIN;
    }

    /**
     * @return UserModule
     */
    protected static function getModule()
    {
        return \Yii::$app->getModule('user');
    }
}