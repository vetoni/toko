<?php

namespace app\components;
use app\models\Comment;

/**
 * Class ActiveQuery
 * @package app\components
 */
class ActiveQuery extends \yii\db\ActiveQuery
{
    /**
     * @return $this
     */
    public function desc()
    {
        $model = $this->modelClass;
        $this->orderBy([$model::primaryKey()[0] => SORT_DESC]);
        return $this;
    }

    /**
     * @return $this
     */
    public function asc()
    {
        $model = $this->modelClass;
        $this->orderBy([$model::primaryKey()[0] => SORT_ASC]);
        return $this;
    }

    /**
     * @return $this
     */
    public function sort()
    {
        $this->orderBy(['sort' => SORT_ASC]);
        return $this;
    }

    /**
     * @return $this
     */
    public function sortDate()
    {
        $this->orderBy(['updated_at' => SORT_DESC]);
        return $this;
    }

    /**
     * @return $this
     */
    public function withAvgRating()
    {
        $modelClass = $this->modelClass;
        $this->select('p.*, COALESCE(AVG(rating), 0) as `rating`')
            ->from(['p' => $modelClass::tableName()])
            ->leftJoin(Comment::tableName(), 'product_id = p.id')
            ->groupBy('p.id');
        return $this;
    }
}