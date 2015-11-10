<?php

namespace app\assets;

use rmrevin\yii\fontawesome\cdn\AssetBundle;

class RatingAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/rating.css',
    ];
    public $depends = [
        '\rmrevin\yii\fontawesome\AssetBundle'
    ];
}