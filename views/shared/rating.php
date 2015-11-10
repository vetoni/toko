<?php

/**
 * @var string $id
 * @var string $name
 * @var double $value
 * @var boolean $readonly
 */
?>
<div class="star-rating">
    <div class="star-rating__wrap">
        <?php
        $a = 1;
        for ($i = 5; $i > 0 ; $i--) {
            $inputOptions = [
                'class' => 'star-rating__input',
                'id' => "$id-star-rating-$i",
                'name' => $name,
            ];
            if ($i == round($value)) {
                $inputOptions['checked'] = 'checked';
            }
            if ($readonly) {
                $inputOptions['disabled'] = 'disabled';
            }
            echo \yii\helpers\Html::input('radio', $name, $i, $inputOptions);
            echo \yii\bootstrap\Html::label('', "$id-star-rating-$i", [
                'class' => 'star-rating__ico fa fa-star-o fa-lg',
                'title' => Yii::t('app', '{0} out of {1} stars', [$i, 5])
            ]);
        }
        ?>
    </div>
</div>
