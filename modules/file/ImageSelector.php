<?php

namespace app\modules\file;

use app\modules\file\assets\FileManagerAsset;
use yii\bootstrap\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\InputWidget;

/**
 * Class ImageSelector
 * @package app\modules\file
 */
class ImageSelector extends InputWidget
{
    /**
     * @var string
     */
    protected $multiple = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->value = $this->model->{$this->attribute};

        if (is_array($this->value)) {
            $this->multiple = true;
        }
        else {
            $this->value = $this->value ? [$this->value] : [];
        }

        $this->options['name'] = $this->hasModel()
            ? Html::getInputName($this->model, $this->attribute)
            : $this->name;

        $this->options['multiple'] = $this->multiple;
        $this->options['url'] = Url::to(['/file/manager/list']);
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->view->registerAssetBundle(FileManagerAsset::className());
        $this->registerClientScript();
        return $this->render('manager/attachments', [
            'images' => $this->value,
            'id' => $this->id,
            'options' =>  $this->options,
        ]);
    }

    /**
     * Registers client script
     */
    public function registerClientScript()
    {
        $encoded = Json::encode($this->options);
        $this->view->registerJs("jQuery({$this->id}).fileManager($encoded);");
    }
}