<?php

namespace app\modules\file\assets;

use yii\web\AssetBundle;

/**
 * Class FileManagerAsset
 * @package app\modules\file\assets
 */
class FileManagerAsset extends AssetBundle
{
    /**
     * @var
     */
    public $basePath = '@webroot';

    /**
     * @var
     */
    public $baseUrl = '@web';

    /**
     * @var array
     */
    public $css = [
        'css/admin/file-manager.css'
    ];
    /**
     * @var array
     */
    public $js = [
        'js/file-manager.js'
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}