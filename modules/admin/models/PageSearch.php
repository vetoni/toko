<?php

namespace app\modules\admin\models;

use app\models\Page;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class PageSearch
 * @package app\modules\admin\models
 */
class PageSearch extends Model
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
    public $type;

    /**
     * @var
     */
    public $slug;

    /**
     * @var
     */
    public $status;

    /**
     * @var
     */
    public $is_system;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'status', 'is_system'], 'integer'],
            [['name', 'type', 'slug'], 'string']
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
        $query = Page::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
                'attributes' => [
                    'id',
                    'name',
                    'type',
                    'slug',
                    'status',
                    'is_system'
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
            'type' => $this->type,
            'is_system' => $this->is_system
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'slug', $this->slug]);
        return $dataProvider;
    }
}