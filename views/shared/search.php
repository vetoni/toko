<?php

use yii\helpers\Url;

?>

<form action="<?= Url::to(['/product/search']) ?>" class="header-search">
    <fieldset>
        <input name="q" placeholder="Search" value="<?= Yii::$app->request->get('q') ?>" type="text">
        <button><i class="glyphicon glyphicon-search"></i></button>
    </fieldset>
</form>