<div class="my-account">
<h2><?= Yii::t('app', 'My account') ?></h2>
<p><?= \yii\helpers\Html::a(Yii::t('app', 'My profile'), ['/user/account/profile']) ?></p>
<p><?= \yii\helpers\Html::a(Yii::t('app', 'Change password'), ['/user/account/change-password']) ?></p>
<p><?= \yii\helpers\Html::a(Yii::t('app', 'My orders'), ['/checkout/order/list']) ?></p>
</div>