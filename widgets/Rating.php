<?php

namespace app\widgets;

use app\assets\RatingAsset;
use yii\bootstrap\Html;
use yii\widgets\InputWidget;

/**
 * Class Rating
 * @package app\widgets
 */
class Rating extends InputWidget
{
    /**
     * @var
     */
    public $readonly;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!isset($this->options['name'])) {
            $this->options['name'] = $this->hasModel() ? Html::getInputName($this->model, $this->attribute) : $this->name;
        }
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $this->view->registerAssetBundle(RatingAsset::className());
        return $this->render('//shared/rating', [
            'id' => $this->options['id'],
            'name' => $this->options['name'],
            'value' => isset($this->value) ? $this->value : $this->model->{$this->attribute},
            'readonly' => $this->readonly
        ]);
    }
}