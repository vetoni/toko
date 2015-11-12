<?php

namespace app\widgets;

use yii\bootstrap\Html;
use yii\bootstrap\Widget;

/**
 * Class BackLink
 * @package app\widgets
 */
class BackLink extends Widget
{
    /**
     * @var
     */
    public $title;

    /**
     * @var
     */
    public $url;

    /**
     * @var
     */
    public $options;

    /**
     * @var
     */
    public $textOnly;

    /**
     * @var string
     */
    protected $arrowTemplate = "<i class=\"glyphicon glyphicon-chevron-left font-12\"></i>";

    /**
     * @return string
     */
    public function run()
    {
        return $this->textOnly
            ? "{$this->arrowTemplate} {$this->title}"
            : Html::a("{$this->arrowTemplate} " . $this->title, $this->url, $this->options);
    }
}
