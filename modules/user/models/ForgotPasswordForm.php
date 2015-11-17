<?php

namespace app\modules\user\models;

use app\models\Settings;
use yii\base\Model;

/**
 * Class ForgotPasswordForm
 * @package app\user\models
 */
class ForgotPasswordForm extends Model
{
    /**
     * @var
     */
    public $email;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'validateEmail'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => \Yii::t('app', 'Email'),
        ];
    }

    /**
     * Validates email
     */
    public function validateEmail()
    {
        if (!User::findOne(['email' => $this->email])) {
            $this->addError('email', \Yii::t('app', 'User with such email does not exist.'));
        }
    }

    /**
     * @return bool
     */
    public function generatePasswordResetToken()
    {
        if (!$this->validate()) {
            return false;
        }

        $new_password = \Yii::$app->security->generateRandomString(8);

        /** @var User $user */
        $user = User::findOne(['email' => $this->email]);
        $user->password_reset_token = User::generatePasswordResetToken();
        $user->password_hash = User::hashPassword($new_password);
        $user->status = User::USER_STATUS_INACTIVE;
        $user->save();

        $isSend = \Yii::$app->mailer->compose('user/forgot_password',
            [
                'user_name' => $user->name,
                'token' => $user->password_reset_token,
                'new_password' => $new_password
            ])
            ->setFrom(Settings::value('general', 'shopEmail'))
            ->setTo($this->email)
            ->setSubject(\Yii::t('mail', 'New password activation'))
            ->send();

        if (!$isSend) {
            $this->addError(\Yii::t('mail', 'Oops, can\'t deliver letter to such email address.'));
        }

        return $isSend;
    }
}