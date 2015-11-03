<?php

namespace app\modules\file\controllers;

use app\modules\file\actions\ImageDeleteAction;
use app\modules\file\actions\ImageUploadAction;
use yii\web\Controller;

/**
 * Class ActionController
 * @package app\modules\file\controllers
 */
class ActionController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
          'upload' => [
            'class' => ImageUploadAction::className()
          ],
          'delete' => [
            'class' => ImageDeleteAction::className()
          ],
        ];
    }
}