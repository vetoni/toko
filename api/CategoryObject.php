<?php

namespace app\api;

use app\components\ApiObject;
use app\models\Category;
use app\models\Product;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;
use yii\widgets\LinkSorter;

/**
 * Class CategoryObject
 * @package app\api
 *
 * @property Category $model
 * @method string getImageUrl()
 * @method string thumb(integer $width, integer $height)
 */
class CategoryObject extends ApiObject
{
    /**
     * @var CategoryObject[]
     */
    protected $_children;

    /**
     * @var ProductObject[]
     */
    protected $_products;

    /**
     * @var CategoryObject[]
     */
    protected $_path;

    /**
     * @var ActiveDataProvider
     */
    protected $_adp;

    /**
     * Determines whether category is leaf
     * @return boolean
     */
    public function isLeaf()
    {
        return $this->model->isLeaf();
    }

    /**
     * Renders pager
     * @param array $options
     * @return string
     * @throws \Exception
     */
    public function pager($options = [])
    {
        return $this->_adp ? LinkPager::widget(array_merge($options, ['pagination' => $this->_adp->pagination])) : '';
    }

    /**
     * Renders sorter
     * @param array $options
     * @return string
     * @throws \Exception
     */
    public function sorter($options = [])
    {
        return $this->_adp ? LinkSorter::widget(array_merge($options, ['sort' => $this->_adp->sort])) : '';
    }

    /**
     * Gets all category child nodes
     * @param $options
     * @return CategoryObject[]
     */
    public function children($options = [])
    {
        if (!isset($this->_children)) {
            /** @var Category $category */
            $category = $this->model;
            $query = $category
                ->children(1)
                ->with('image')
                ->andWhere(['status' => 1]);

            $this->_adp= new ActiveDataProvider([
                'query' => $query,
                'pagination' => isset($options['pagination']) ? $options['pagination'] : [],
            ]);

            foreach ($this->_adp->models as $model) {
                $this->_children[] = new static($model);
            }
        }
        return $this->_children;
    }

    /**
     * Gets products of this category
     * @param $options
     * @return ProductObject[]
     */
    public function products($options = [])
    {
        if (!isset($this->_products)) {
            /** @var Category $category */
            $category = $this->model;
            $query = Product::find()
                ->where(['category_id' => $category->id, 'status' => 1])
                ->with('image');

            $this->_adp = new ActiveDataProvider([
                'query' => $query,
                'pagination' => isset($options['pagination']) ? $options['pagination'] : [],
                'sort' => isset($options['sort']) ? $options['pagination'] : [],
            ]);

            foreach ($this->_adp->models as $model) {
                $this->_products[] = new ProductObject($model);
            }
        }
        return $this->_products;
    }

    /**
     * Gets node path beginning from root
     * @return Category[]
     */
    public function getNodePath()
    {
        if (!isset($this->_path)) {
            return array_merge($this->model->parents()->all(), [$this->model]);
        }
        return $this->_path;
    }
}