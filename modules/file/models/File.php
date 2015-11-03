<?php

namespace app\modules\file\models;

use app\components\ActiveRecord;
use app\modules\file\FileModule;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Inflector;
use yii\web\UploadedFile;

/**
 * Class File
 * @package app\file\models
 *
 * @property int $id
 * @property string $name
 * @property string $extension
 * @property string $original_name
 * @property string $mime_type
 * @property int $size
 *
 * @property FileModule $module
 * @property string $url
 * @property string $path
 */
class File extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%file}}';
    }

    /**
     * @return FileModule
     */
    public function getModule()
    {
        return FileModule::getInstance();
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className()
            ]
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'extension', 'original_name', 'size'], 'required'],
            ['name', 'string', 'max' => 255],
            ['extension', 'in', 'range' => $this->module->imageAllowExtensions],
            ['original_name', 'string', 'max' => 255],
            ['mime_type', 'string', 'max' => 45],
            ['size', 'integer', 'min' => 0]
        ];
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return \Yii::getAlias("{$this->module->storageUrl}/{$this->name}.{$this->extension}");
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return \Yii::getAlias("{$this->module->storagePath}/{$this->name}.{$this->extension}");
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function delete()
    {
        if (parent::delete() === false) {
            return false;
        }
        return unlink($this->path);
    }

    /**
     * @return bool
     */
    public function upload()
    {
        $uploadedFile = UploadedFile::getInstanceByName('file');

        if (!$uploadedFile) {
            return false;
        }

        $name = date('Y') . '/' . date('m');

        $dir = \Yii::getAlias("{$this->module->storagePath}/$name");

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $name .= '/' . substr(uniqid(md5(rand()), true), 0, 10);
        $name .= '-' . Inflector::slug($uploadedFile->baseName);

        $this->name = $name;
        $this->extension = $uploadedFile->extension;
        $this->mime_type = $uploadedFile->type;
        $this->original_name = $uploadedFile->name;
        $this->size = $uploadedFile->size;

        if (!$uploadedFile->saveAs($this->path)) {
            return false;
        }
        return $this->save();
    }

    /**
     * @param $source
     * @return bool
     */
    public function uploadFrom($source)
    {
        if (!file_exists($source)) {
            return false;
        }

        $name = date('Y') . '/' . date('m');

        $dir = \Yii::getAlias("{$this->module->storagePath}/$name");

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $mime_type = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $source);

        $info = pathinfo($source);

        $name .= '/' . substr(uniqid(md5(rand()), true), 0, 10);
        $name .= '-' . Inflector::slug($info['filename']);

        $this->name = $name;
        $this->extension = strtolower($info['extension']);
        $this->mime_type = $mime_type;
        $this->original_name = $info['basename'];
        $this->size = filesize($source);

        if (!copy($source, $this->path)) {
            return false;
        }
        return $this->save();
    }

    /**
     * @return string
     */
    public function getSize()
    {
        $bytes = sprintf('%u', filesize($this->path));

        if ($bytes > 0)
        {
            $unit = intval(log($bytes, 1024));
            $units = array('B', 'KB', 'MB', 'GB');

            if (array_key_exists($unit, $units) === true)
            {
                return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
            }
        }

        return $bytes;
    }
}