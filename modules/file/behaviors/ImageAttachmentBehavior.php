<?php

namespace app\modules\file\behaviors;

use app\modules\file\FileModule;
use app\modules\file\models\Image;
use Imagine\Exception\InvalidArgumentException;
use ReflectionClass;
use yii\base\Behavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\Inflector;

/**
 * Class ImageAttachmentBehavior
 * @package app\modules\file\behaviors
 *
 * @property ActiveRecord $owner
 * @property string $modelShortName
 */
class ImageAttachmentBehavior extends Behavior
{
    /**
     * @var string
     */
    public $junctionTable = '{{%file_attachment}}';

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'saveAttachments',
            ActiveRecord::EVENT_AFTER_UPDATE => 'saveAttachments',
            ActiveRecord::EVENT_AFTER_DELETE => 'deleteAttachments',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getImage()
    {
        return $this->owner
            ->hasOne(Image::className(), ['id' => 'file_id'])
            ->viaTable(
                "fa",
                ['item_id' => 'id'],
                function ($query) {
                    // image with minimum sort value is considered to be primary
                    $query->from(['fa' => $this->junctionTable]);
                    $subQuery = (new Query())
                        ->select('model, item_id, min(sort) as min_sort')
                        ->from($this->junctionTable)
                        ->groupBy('model, item_id');
                    $query->innerJoin(['t' => $subQuery],
                        "fa.model=t.model AND fa.item_id=t.item_id AND fa.sort=t.min_sort");
                    $query->andOnCondition(["fa.model" => $this->getModelShortName()]);
                }
            );
    }

    /**
     * @return Image[]
     */
    public function getImages()
    {
        if (!$this->_images) {
            $this->_images = Image::find()
                ->innerJoin(
                    $this->junctionTable,
                    Image::tableName() . ".id=file_id AND model=:model AND item_id=:item_id",
                    ['item_id' => $this->owner->getPrimaryKey(), 'model' => $this->getModelShortName()]
                )
                ->sort()
                ->all();
        }
        return $this->_images;
    }

    /**
     * @var Image[]
     */
    protected $_images;

    /**
     * @var Image
     */
    protected $_image;

    /**
     * @param $width
     * @param $height
     * @return string
     */
    public function thumb($width, $height)
    {
        /** @var Image $image */
        if (!$this->_image) {
            $this->_image = $this->owner->image
                ? $this->owner->image->getThumbnail($width, $height)
                : FileModule::getInstance()->placeholderUrl;
        }
        return $this->_image;
    }

    /**
     * @return string|null
     */
    public function getImageUrl()
    {
        /** @var Image $image */
        if (!$this->_image) {
            $this->_image = $this->owner->image
                ? $this->owner->image->url : null;
        }
        return $this->_image;
    }

    /**
     * @throws \yii\db\Exception
     */
    public function saveAttachments()
    {
        $data = \Yii::$app->request->post($this->owner->formName());
        $attachments = null;

        if (isset($data['images'])) {
            $attachments = $data['images'];
        }

        if (isset($data['image'])) {
            $attachments = $data['image'];
        }

        if (isset($attachments)) {
            $this->deleteAttachments();
            if (is_array($attachments)) {
                foreach (array_keys($attachments) as $sort => $fileId) {
                    /** @var Image $image */
                    $image = Image::findOne(['id' => $fileId]);
                    if ($image) {
                        $this->owner
                            ->getDb()
                            ->createCommand()
                            ->insert(
                                $this->junctionTable,
                                [
                                    'file_id' => $fileId,
                                    'model' => $this->modelShortName,
                                    'item_id' => $this->owner->getPrimaryKey(),
                                    'sort' => $sort + 1
                                ]
                            )
                            ->execute();
                    }
                }
            }
        }
    }

    /**
     * Deletes attachments
     */
    public function deleteAttachments()
    {
        $this->owner
            ->getDb()
            ->createCommand()
            ->delete($this->junctionTable,
                [
                    'model' => $this->modelShortName,
                    'item_id' => $this->owner->getPrimaryKey()
                ]
            )
            ->execute();
    }

    /**
     * @param $path
     * @param bool|false $primary
     * @return bool
     * @throws \yii\db\Exception
     */
    public function attachImage($path, $primary = false)
    {
        $image = new Image();

        if (!$image->uploadFrom($path)) {
            throw new InvalidArgumentException("File can not be copied: $path");
        }

        $itemId = $this->owner->primaryKey;
        $model = $this->getModelShortName();

        $query = (new Query())
            ->from($this->junctionTable)
            ->where([
                'model' => $model,
                'item_id' => $itemId,
            ]);

        $sort = $primary
            ? $query->min('sort') - 1
            : $query->max('sort') + 1;


        $this->owner->getDb()
            ->createCommand()
            ->insert($this->junctionTable, [
                'file_id' => $image->id,
                'model' => $model,
                'item_id' => $itemId,
                'sort' => $sort,
            ])
            ->execute();

        return true;
    }

    /**
     * @return string
     */
    protected function getModelShortName()
    {
        return (new ReflectionClass($this->owner->className()))->getShortName();
    }

    /**
     * Expose [[$translationAttributes]] writable
     * @inheritdoc
     */
    public function canSetProperty($name, $checkVars = true)
    {
        return $this->isBehaviorAttribute($name) ? true : parent::canSetProperty($name, $checkVars);
    }

    /**
     * Expose [[$translationAttributes]] readable
     * @inheritdoc
     */
    public function canGetProperty($name, $checkVars = true)
    {
        return $this->isBehaviorAttribute($name) ? true : parent::canGetProperty($name, $checkVars);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasMethod($name)
    {
        return $this->isBehaviorAttribute(ltrim($name, 'get')) ? true : parent::hasMethod($name);
    }

    /**
     * @param $attribute
     * @return bool
     */
    protected function isPlural($attribute)
    {
        return $attribute === Inflector::pluralize($attribute);
    }

    /**
     * @param $name
     * @return bool
     */
    protected function isBehaviorAttribute($name)
    {
        return $name == 'images' || $name == 'image';
    }
}