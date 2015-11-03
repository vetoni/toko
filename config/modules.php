<?php

return [
    'admin' => [
        'class' => 'app\modules\admin\AdminModule',
        'layout' => 'main',
    ],
    'user' => [
        'class' => 'app\modules\user\UserModule',
    ],
    'install' => [
        'class' => 'app\modules\install\InstallModule',
        'layout' => '@app/views/layouts/base',
    ],
    'treemanager' =>  [
        'class' => '\kartik\tree\Module',
    ],
    'redactor' => [
        'class' => 'yii\redactor\RedactorModule',
        'uploadDir' => '@webroot/files/redactor',
        'uploadUrl' => '@web/files/redactor',
        'imageAllowExtensions' => ['jpg','jpeg','png','gif'],
    ],
    'file' => [
        'class' => 'app\modules\file\FileModule',
        'maxFileSize' => 10 * 1024 * 1024,
        'imageAllowExtensions' => ['jpg','jpeg','png','gif'],
        'storageUrl' => '@web/files/uploads',
        'storagePath' => '@webroot/files/uploads',
        'placeholderUrl' => '@web/files/img/placeholder.png',
    ]
];
