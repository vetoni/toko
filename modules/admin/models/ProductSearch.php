<?php

namespace app\modules\admin\models;

use app\models\Product;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

/**
 * Class ProductSearch
 * @package app\modules\admin\models
 */
class ProductSearch extends Model
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
    public $status;

    /**
     * @var
     */
    public $node;

    /**
     * @var
     */
    public $price;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'status', 'node'], 'integer'],
            [['name'], 'string'],
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
        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
                'attributes' => [
                    'id',
                    'name',
                    'status',
                    'price'
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
            'category_id' => $this->node,
         ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}