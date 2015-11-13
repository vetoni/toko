<?php

namespace app\behaviors;

use app\components\ActiveQuery;
use app\components\ActiveRecord;
use ReflectionClass;
use yii\base\Behavior;
use yii\db\Query;

/**
 * Class RelatedItemsBehavior
 * @package app\components\behaviors
 *
 * @property ActiveRecord $owner
 * @property string $relationInfo
 */
class RelatedItemsBehavior extends Behavior
{
    /**
     * @var string
     */
    public $relatedModelClass;

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_UPDATE => 'saveRelated',
            ActiveRecord::EVENT_AFTER_DELETE => 'deleteRelated',
        ];
    }

    /**
     * @return string
     */
    public function getRelationInfo()
    {
        $list = (new Query())
            ->select('related_id')
            ->from("{{%relation}}")
            ->where(['item_id' => $this->owner->getPrimaryKey(), 'model' => $this->getShortName()])
            ->column();
        return implode(';', $list);
    }

    /**
     * @param $value
     */
    public function setRelationInfo($value)
    {
        $this->relationInfo = $value;
    }

    /**
     * @return ActiveQuery
     */
    public function getRelated()
    {
        $class = $this->relatedModelClass;
        $query = $class::find()
            ->from(['p' => $class::tableName()])
            ->innerJoin(['r' => "{{%relation}}"], "p.id = r.related_id")
            ->andWhere(['r.item_id' => $this->owner->getPrimaryKey()]);

        if ($this->owner->hasProperty('image')) {
            $query->with('image');
        }

        return $query;
    }

    /**
     * Saves related products
     */
    public function saveRelated()
    {
        $ids = explode(';', $this->relationInfo);
        $this->owner->unlinkAll('related', true);
        foreach ($ids as $id) {
            $class = $this->owner->className();
            $item = $class::findOne(trim($id));
            if ($item) {
                $this->owner->link('related', $item, ['model' => $this->getShortName()]);
            }
        }
    }

    /**
     * Deletes related products
     */
    public function deleteRelated()
    {
        $this->owner->unlinkAll('related', true);
    }

    /**
     * @return string
     */
    protected function getShortName()
    {
        return (new ReflectionClass($this->relatedModelClass))->getShortName();
    }
}