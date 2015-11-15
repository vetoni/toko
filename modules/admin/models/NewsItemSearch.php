<?php

namespace app\modules\admin\models;

use app\models\NewsItem;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class NewsItemSearch
 * @package app\modules\admin\models
 */
class NewsItemSearch extends Model
{
    /**
     * @var
     */
    public $id;

    /**
     * @var
     */
    public $name;

    /**
     * @var
     */
    public $author_id;

    /**
     * @var
     */
    public $slug;

    /**
     * @var
     */
    public $status;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'status', 'author_id'], 'integer'],
            [['name', 'slug'], 'string']
        ];
    }

    /**
     * @return string
     */
    public function formName()
    {
        return '';
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = NewsItem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
                'attributes' => [
                    'id',
                    'name',
                    'slug',
                    'status',
                    'author_id',
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
            'author_id' => $this->author_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'slug', $this->slug]);
        return $dataProvider;
    }
}