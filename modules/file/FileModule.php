<?php

namespace app\modules\file;
use app\modules\file\models\Image;
use yii\base\Module;


/**
 * Class FileModule
 * @package app\modules\file
 */
class FileModule extends Module
{
    /**
     * @var array
     */
    public $imageAllowExtensions = [];

    /**
     * @var string
     */
    public $storageUrl = '@web/path-to-storage';

    /**
     * @var string
     */
    public $storagePath = '@webroot/path-to-storage';

    /**
     * @var string
     */
    public $placeholderUrl = '@web/path-to-placeholder';

    /**
     * @var string
     */
    public $layout = 'main';

    /**
     * @var int
     */
    public $maxFileSize = 2000000;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return string
     */
    public function getPlaceHolder()
    {
        return \Yii::getAlias($this->placeholderUrl);
    }

    /**
     * @return static
     */
    public static function getInstance()
    {
        return \Yii::$app->getModule('file');
    }
}