<?php

namespace app\modules\file\models;
use Imagine\Image\ManipulatorInterface;
use Yii;

/**
 * Class Image
 * @package app\modules\file\models
 */
class Image extends File
{
    /**
     * @return bool
     */
    public function delete()
    {
        if (parent::delete() === false) {
            return false;
        }

        $this->deleteThumbnails();
        return true;
    }

    /**
     * Delete thumbnails
     */
    public function deleteThumbnails()
    {
        $pattern = Yii::getAlias($this->module->storagePath) . "/{$this->name}*.{$this->extension}";
        array_map('unlink', glob($pattern));
    }

    /**
     * @param $width
     * @param $height
     * @return string
     */
    public function getThumbnail($width, $height)
    {
        $thumb = "{$this->name}-{$width}x{$height}.{$this->extension}";
        $thumbFile = Yii::getAlias($this->module->storagePath) . '/' . $thumb;
        $thumbUrl = Yii::getAlias($this->module->storageUrl) . '/' . $thumb;
        if (file_exists($this->path) && !file_exists($thumbFile)) {
            \yii\imagine\Image::thumbnail($this->path, $width, $height, ManipulatorInterface::THUMBNAIL_INSET)->save($thumbFile, ['quality' => 60]);
        }
        return $thumbUrl;
    }
}