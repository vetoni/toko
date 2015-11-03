<?php

namespace app\modules\file\actions;

use app\modules\file\models\Image;
use yii\base\Action;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * Class ImageUploadAction
 * @package app\file\actions
 */
class ImageUploadAction extends Action
{
    /**
     * @return string
     */
    public function run()
    {
        $file = new Image();
        return $file->upload()
            ? $this->getSuccessResponse($file)
            : $this->getErrorResponse($file);
    }

    /**
     * @param $file Image
     * @return string
     */
    protected function getSuccessResponse($file)
    {
        return Json::encode([
            'files' => [
                [
                    'name' => $file->name,
                    'size' => $file->size,
                    'url' => $file->url,
                    'thumbnailUrl' => $file->getThumbnail(80, 70),
                    'deleteUrl' => Url::to(['action/delete', 'id' => $file->id]),
                    'deleteType' => 'DELETE',
                ]
            ]
        ]);
    }

    /**
     * @param $file Image
     * @return string
     */
    protected function getErrorResponse($file)
    {
        $message = $file->getFirstError('mime_type');

        return Json::encode([
            'files' => [
                [
                    'name' => $file->name,
                    'size' => $file->size,
                    'error' => $message ?: \Yii::t('app', 'File can not be uploaded.'),
                ]
            ]
        ]);
    }
}