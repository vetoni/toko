<?php

namespace app\modules\admin\models;

use app\models\Comment;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class CommentSearch
 * @package app\modules\admin\models
 */
class CommentSearch extends Model
{
    /**
     * @var
     */
    public $id;

    /**
     * @var
     */
    public $product_id;

    /**
     * @var
     */
    public $user_id;

    /**
     * @var
     */
    public $rating;

    /**
     * @var
     */
    public $body;

    /**
     * @var
     */
    public $status;

    /**
     * @return string
     */
    public function formName()
    {
        return '';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'user_id', 'status'], 'integer'],
            ['rating', 'double'],
            ['body', 'string']
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Comment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => 'id',
                'attributes' => [
                    'id',
                    'product_id',
                    'user_id',
                    'rating',
                    'status',
                    'created_at'
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'status' => $this->status,
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,
            'rating' => $this->rating,
        ]);

        $query->andFilterWhere(['LIKE', 'body', $this->body]);

        return $dataProvider;
    }

}