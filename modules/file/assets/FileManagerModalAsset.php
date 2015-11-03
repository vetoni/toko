<?php

namespace app\modules\file\assets;

use yii\web\AssetBundle;

/**
 * Class FileManagerModalAsset
 * @package app\modules\file\assets
 */
class FileManagerModalAsset extends AssetBundle
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
        'css/admin/file-manager.modal.css'
    ];
    /**
     * @var array
     */
    public $js = [

    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}