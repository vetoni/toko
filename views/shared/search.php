<?php

use yii\helpers\Url;

?>

<form action="<?= Url::to(['/product/search']) ?>" class="search-box">
    <fieldset>
        <input name="q" placeholder="<?= Yii::t('app', 'Search') ?>" value="<?= Yii::$app->request->get('q') ?>" type="text">
        <button><i class="glyphicon glyphicon-search"></i></button>
    </fieldset>
</form>