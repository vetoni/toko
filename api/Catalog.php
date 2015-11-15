<?php

namespace app\api;

use app\components\Api;
use app\models\Category;
use app\models\Product;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;
use yii\widgets\LinkSorter;

/**
 * Class Catalog
 * @package app\api
 *
 * @method static string pager(array $options = [])
 * @method static string sorter(array $options = [])
 * @method static CategoryObject cat($id_slug)
 * @method static CategoryObject[] cats(array $options = [])
 * @method static ProductObject product($id_slug)
 * @method static ProductObject[] search($q, array $options = [])
 * @method static ProductObject[] new_products()
 */
class Catalog extends Api
{
    /**
     * @var
     */
    protected $_cats;

    /**
     * @var
     */
    protected $_prods;

    /**
     * @var
     */
    protected $_roots;

    /**
     * @var
     */
    protected $_search_result;

    /**
     * @var
     */
    protected $_new_products;

    /**
     * @var
     */
    protected $_adp;

    /**
     * @param array $options
     * @return string
     * @throws \Exception
     */
    public function api_pager($options = [])
    {
        return $this->_adp ? LinkPager::widget(array_merge($options, ['pagination' => $this->_adp->pagination])) : '';
    }

    /**
     * Renders sorter
     * @param array $options
     * @return string
     * @throws \Exception
     */
    public function api_sorter($options = [])
    {
        return $this->_adp ? LinkSorter::widget(array_merge($options, ['sort' => $this->_adp->sort])) : '';
    }

    /**
     * Get category by id or slug
     * @param $id_slug
     * @return CategoryObject
     */
    public function api_cat($id_slug)
    {
        if (!isset($this->_cats[$id_slug])) {
            $this->_cats[$id_slug] = $this->findCategory($id_slug);
        }
        return $this->_cats[$id_slug];
    }

    /**
     * Get all root categories
     * @param $options
     * @return CategoryObject[]
     */
    public function api_cats($options = [])
    {
        if (!isset($this->_roots)) {
            $query = Category::find()
                ->roots()
                ->with('image')
                ->andWhere(['status' => 1]);

            $this->_adp = new ActiveDataProvider([
                'query' => $query,
                'pagination' => isset($options['pagination']) ? $options['pagination'] : [],
            ]);

            foreach ($this->_adp->models as $model) {
                $this->_roots[] = $this->_cats[$model->id] = new CategoryObject($model);
            }
        }
        return $this->_roots;
    }

    /**
     * @param $id_slug
     * @return ProductObject
     */
    public function api_product($id_slug)
    {
        if (!isset($this->_prods[$id_slug])) {
            $this->_prods[$id_slug] =  $this->findProduct($id_slug);
        }
        return $this->_prods[$id_slug];
    }

    /**
     * @param $q
     * @param array $options
     * @return \app\models\Product[]
     */
    public function api_search($q, $options = [])
    {
        /** @var Product[] $products */
        $query = Product::find()
            ->with('image')
            ->withAvgRating()
            ->orFilterWhere(['LIKE', 'p.name', $q])
            ->orFilterWhere(['LIKE', 'p.announce', $q])
            ->orFilterWhere(['LIKE', 'p.description', $q])
            ->andWhere(['p.status' => 1]);

        $this->_adp = new ActiveDataProvider([
            'query' => $query,
            'pagination' => isset($options['pagination']) ? $options['pagination'] : [],
            'sort' => isset($options['sort']) ? $options['sort'] : [],
        ]);

        foreach ($this->_adp->models as $model) {
            $this->_search_result[] = $this->_prods[$model->id] = new ProductObject($model);
        }

        return $this->_search_result;
    }

    /**
     * @return ProductObject[]
     */
    public function api_new_products()
    {
        if (!isset($this->_new_products)) {
            $query = Product::find()
                ->with('image')
                ->withAvgRating()
                ->andWhere(['p.status' => 1])
                ->sortDate()
                ->limit(8);

            $this->_adp = new ActiveDataProvider([
                'query' => $query,
            ]);

            foreach ($this->_adp->models as $model) {
                $this->_new_products[] = new ProductObject($model);
            }
        }
        return $this->_new_products;
    }

    /**
     * @param $id_slug
     * @return CategoryObject|null
     */
    protected function findCategory($id_slug)
    {
        $model = Category::find()->where(['AND', ['OR', ['id' => $id_slug], ['slug' => $id_slug]], ['status' => 1]])->one();
        return isset($model) ? new CategoryObject($model) : null;
    }

    /**
     * @param $id_slug
     * @return ProductObject|null
     */
    protected function findProduct($id_slug)
    {
        $query = Product::find()->withAvgRating();
        $result = $query->where(['AND', ['OR', ['p.id' => $id_slug], ['p.slug' => $id_slug]], ['p.status' => 1]])->one();

        return isset($result) ? new ProductObject($result) : null;
    }
}