<?php

namespace app\modules\file\actions;
use app\modules\file\models\Image;
use yii\base\Action;
use yii\helpers\Json;

/**
 * Class ImageDeleteAction
 * @package app\modules\file\actions
 */
class ImageDeleteAction extends Action
{
    /**
     * @param $id
     * @return string
     */
    public function run($id)
    {
        /** @var Image $file */
        $file = Image::findOne(['id' => $id]);
        $deleted = $file->delete();
        return $this->getResponse($file, $deleted);
    }

    /**
     * @param $file
     * @param $deleted
     * @return string
     */
    protected function getResponse($file, $deleted)
    {
        return Json::encode([
            'files' => [
                [
                    $file->original_name => $deleted
                ]
            ]
        ]);
    }
}