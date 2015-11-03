<?php

namespace app\modules\user\models;

use yii\base\Model;

/**
 * Class RegisterForm
 * @package app\user\models
 */
class RegisterForm extends Model
{
    /**
     * @var
     */
    public $email;

    /**
     * @var
     */
    public $name;

    /**
     * @var
     */
    public $password;

    /**
     * @var
     */
    public $password_confirm;

    /**
     * @var
     */
    public $country_id;

    /**
     * @var
     */
    public $address;

    /**
     * @var
     */
    public $phone;

    /**
     * @var
     */
    public $image;

    /**
     * @return string
     */
    public function formName()
    {
        return "User";
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email', 'name', 'password', 'country_id', 'address', 'phone'], 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => '255'],
            ['email', 'validateEmail'],
            ['name', 'string', 'max' => '255'],
            ['password', 'string', 'min' => 4, 'max' => '20'],
            ['password_confirm', 'compare', 'compareAttribute' => 'password'],
            ['country_id', 'string', 'max' => '10'],
            ['address', 'string', 'max' => '255'],
            ['phone', 'string', 'max' => '255'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => \Yii::t('app', 'Email'),
            'name' => \Yii::t('app', 'Name'),
            'country_id' => \Yii::t('app', 'Country'),
            'address' => \Yii::t('app', 'Address'),
            'phone' => \Yii::t('app', 'Phone'),
            'password' => \Yii::t('app', 'Password'),
            'password_confirm' => \Yii::t('app', 'Password confirm'),
            'image' => \Yii::t('app', 'Photo'),
        ];
    }

    /**
     * Validates email
     */
    public function validateEmail()
    {
        if (User::findIdentityByEmail($this->email)) {
            $this->addError('email', \Yii::t('app', 'User with such email is already registered.'));
        }
    }

    /**
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->email = $this->email;
        $user->name = $this->name;
        $user->country_id = $this->country_id;
        $user->phone = $this->phone;
        $user->address = $this->address;
        $user->password_hash = User::hashPassword($this->password);
        $user->generateAuthKey();
        $user->status = User::USER_STATUS_ACTIVE;
        $user->save();

        return User::login($this->email, true);
    }
}