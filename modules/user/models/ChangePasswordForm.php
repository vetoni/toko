<?php

namespace app\modules\user\models;

use yii\base\Model;

/**
 * Class ChangePasswordForm
 * @package app\user\models
 */
class ChangePasswordForm extends Model
{
    /**
     * @var
     */
    public $password;

    /**
     * @var
     */
    public $new_password;

    /**
     * @var
     */
    public $new_password_confirm;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'validatePassword'],
            ['new_password', 'validateNewPassword'],
            ['new_password', 'required'],
            ['new_password', 'string', 'min' => 4, 'max' => '20'],
            ['new_password_confirm', 'compare', 'compareAttribute' => 'new_password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => \Yii::t('app', 'Password'),
            'new_password' => \Yii::t('app', 'New password'),
            'new_password_confirm' => \Yii::t('app', 'New password confirm'),
        ];
    }

    /**
     * Validates new password
     */
    public function validateNewPassword()
    {
        if ($this->password === $this->new_password) {
            $this->addError('new_password', \Yii::t('app', 'New password should differ from the old one.'));
        }
    }


    /**
     * Validates password
     */
    public function validatePassword()
    {
        $user = User::findIdentity(\Yii::$app->user->identity->getId());
        if (!$user->validatePassword($this->password)) {
            $this->addError('password', \Yii::t('app', 'Incorrect password.'));
        }
    }

    /**
     * @return bool
     */
    public function changePassword()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = User::findIdentity(\Yii::$app->user->identity->getId());
        $user->password_hash = User::hashPassword($this->new_password);
        $user->save();

        return true;
    }
}