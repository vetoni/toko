<?php

namespace app\api;

use app\components\Api;
use app\models\Category;
use app\models\Product;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;

/**
 * Class Catalog
 * @package app\api
 *
 * @method static string pager(array $options = [])
 * @method static CategoryObject cat(string $id_slug)
 * @method static CategoryObject[] cats(array $options = [])
 * @method static ProductObject product(string $id_slug)
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
            $query = Category::find()->roots()->with('image');
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
     * @param $id_slug
     * @return CategoryObject|null
     */
    protected function findCategory($id_slug)
    {
        $model = Category::find()->where(['OR', ['id' => $id_slug], ['slug' => $id_slug]])->one();
        return isset($model) ? new CategoryObject($model) : null;
    }

    /**
     * @param $id_slug
     * @return ProductObject|null
     */
    protected function findProduct($id_slug)
    {
        $result = Product::find()->where(['AND', ['OR', ['id' => $id_slug], ['slug' => $id_slug]], ['status' => 1]])->one();
        return isset($result) ? new ProductObject($result) : null;
    }
}