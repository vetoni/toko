<?php

namespace app\api;

use app\components\ApiObject;
use app\models\Comment;
use app\models\Product;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;

/**
 * Class ProductObject
 * @package app\api
 *
 * @property Product $model
 * @method string getImageUrl()
 * @method string thumb($width, $height)
 */
class ProductObject extends ApiObject
{
    /**
     * @var ProductObject[]
     */
    protected $_related;

    /**
     * @var Comment[]
     */
    protected $_comments;

    /**
     * @var ActiveDataProvider
     */
    protected $_adp;

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
     * @param array $options
     * @return ProductObject[]
     */
    public function related($options = [])
    {
        if (!isset($this->_related)) {
            $query = $this->model
                ->getRelated()
                ->withAvgRating()
                ->andWhere(['p.status' => 1]);
            $this->_adp= new ActiveDataProvider([
                'query' => $query,
                'pagination' => isset($options['pagination']) ? $options['pagination'] : [],
            ]);

            foreach ($this->_adp->models as $product) {
                $this->_related[] = new static($product);
            }
        }
        return $this->_related;
    }

    /**
     * @param array $options
     * @return \app\models\Comment[]
     */
    public function comments($options = [])
    {
        if (!isset($this->_comments)) {
            $query = $this->model->getComments()->where(['status' => 1]);
            $this->_adp= new ActiveDataProvider([
                'query' => $query,
                'pagination' => isset($options['pagination']) ? $options['pagination'] : [],
            ]);

            $this->_comments = $this->_adp->models;
        }
        return $this->_comments;
    }
}