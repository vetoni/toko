<?php

namespace app\modules\install\assets;

use yii\web\AssetBundle;

/**
 * Class InstallAsset
 * @package app\modules\install\assets
 */
class InstallAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $basePath = '@webroot';

    /**
     * @var string
     */
    public $baseUrl = '@web';

    /**
     * @var array
     */
    public $js = [];

    /**
     * @var array
     */
    public $css = [
        'css/installer.css'
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}