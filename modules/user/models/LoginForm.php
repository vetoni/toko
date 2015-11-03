<?php

namespace app\modules\user\models;

use yii\base\Model;

/**
 * Class LoginForm
 * @package app\user\models
 */
class LoginForm extends Model
{
    /**
     * @var
     */
    public $email;

    /**
     * @var
     */
    public $password;

    /**
     * @var
     */
    public $remember_me;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => '255'],
            ['email', 'validateEmail'],
            ['password', 'string', 'min' => 4, 'max' => '20'],
            ['remember_me', 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => \Yii::t('app', 'Email'),
            'password' => \Yii::t('app', 'Password'),
            'remember_me' => \Yii::t('app', 'Remember me'),
        ];
    }

    /**
     * @return bool
     */
    public function validateEmail()
    {
        $user = User::findIdentityByEmail($this->email);
        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError('email', \Yii::t('app', 'Incorrect user email or password.'));
        }
    }

    /**
     * @return bool
     */
    public function login()
    {
        if ($this->validate()) {
            return User::login($this->email, $this->remember_me);
        }
        return false;
    }

}