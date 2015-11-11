<?php

/**
 * @var string $token
 * @var string $user_name
 * @var string $new_password
 * @var string $url
 */

$url = \yii\helpers\Url::to(['/user/account/activate', 'token' => $token], true);
?>
<p><?= Yii::t('mail', 'Hello, ') . $user_name . '!' ?></p>
<p><?= Yii::t('mail', 'You are receiving this email because you (or someone pretending to be you) asked to send a new password to your account on web site.
If you did not ask to send the password, you should not pay attention to this letter, and if such mail continue to arrive, contact our administration.') ?></p>
<p><?= Yii::t('mail', 'Before using the new password you have to activate it. Follow the link below: ') ?></p>
<p><?= \yii\helpers\Html::a($url, $url);?></p>
<p><?= Yii::t('mail', 'After successful activation you can log in using the following password: ') ?></p>
<p><?= Yii::t('mail', 'Password: ') . $new_password ?></p>
<p><?= Yii::t('mail', 'Thanks, site administration.') ?></p>