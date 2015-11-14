<?php

namespace app\components;

use app\models\Comment;

class ProductQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function withAvgRating()
    {
        $this->select('p.*, COALESCE(AVG(rating), 0) as `rating`')
            ->from(['p' => '{{%product}}'])
            ->leftJoin(Comment::tableName(), 'product_id = p.id')
            ->groupBy('p.id');
        return $this;
    }
}