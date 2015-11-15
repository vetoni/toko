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
 * @property string $related
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
            ActiveRecord::EVENT_AFTER_UPDATE => 'saveRelatedItems',
            ActiveRecord::EVENT_AFTER_DELETE => 'deleteRelatedItems',
        ];
    }

    /**
     * @return string
     */
    public function getRelated()
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
    public function setRelated($value)
    {
        $this->related = $value;
    }

    /**
     * @return ActiveQuery
     */
    public function withRelatedItems()
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
    public function saveRelatedItems()
    {
        $ids = explode(';', $this->related);

        $db = \Yii::$app->getDb();
        $this->deleteRelatedItems($db);
        foreach ($ids as $id) {
            $class = $this->owner->className();
            $item = $class::findOne(trim($id));
            if ($item) {
                $db->createCommand()
                    ->insert("{{%relation}}", [
                        'item_id' => $this->owner->getPrimaryKey(),
                        'related_id' => $id,
                        'model' => $this->getShortName()
                    ])
                    ->execute();
            }
        }
    }

    /**
     * Deletes related products
     * @param \yii\db\Connection $db
     */
    public function deleteRelatedItems($db)
    {
        $db->createCommand()
            ->delete("{{%relation}}", ['item_id' => $this->owner->getPrimaryKey()])
            ->execute();
    }

    /**
     * @return string
     */
    protected function getShortName()
    {
        return (new ReflectionClass($this->relatedModelClass))->getShortName();
    }
}