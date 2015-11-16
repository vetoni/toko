<?php

namespace app\api;

use app\components\Api;
use app\helpers\Data;
use app\models\NewsItem;
use app\models\Page;
use app\modules\user\models\Country;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;

/**
 * Class Shop
 * @package app\api
 *
 * @method static PageObject page($id_slug)
 * @method static PageObject[] pages($options = [])
 * @method static NewsItemObject news_item($id_slug)
 * @method static NewsItemObject[] news_items($options = [])
 * @method static Country[] countries()
 * @method static string pager($options = [])
 */
class Shop extends Api
{
    /**
     * @var PageObject[]
     */
    protected $_page;

    /**
     * @var PageObject[]
     */
    protected $_pages;

    /**
     * @var NewsItemObject[]
     */
    protected $_news_item;

    /**
     * @var NewsItemObject[]
     */
    protected $_news_items;

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
    public function api_pager($options = [])
    {
        return $this->_adp ? LinkPager::widget(array_merge($options, ['pagination' => $this->_adp->pagination])) : '';
    }

    /**
     * @param $id_slug
     * @return PageObject
     */
    public function api_page($id_slug)
    {
        if (!isset($this->_page[$id_slug])) {
            $this->_page[$id_slug] = $this->findPage($id_slug);
        }
        return $this->_page[$id_slug];
    }

    /**
     * @param array $options
     * @return PageObject[]
     */
    public function api_pages($options = [])
    {
        if (!isset($this->_pages)) {

            $query = Page::find();

            if (!empty($options['nonSystemOnly'])) {
                $query->andWhere(['is_system' => 0]);
            }

            $query->sortDate();

            $this->_adp = new ActiveDataProvider([
                'query' => $query,
                'pagination' => isset($options['pagination']) ? $options['pagination'] : [],
            ]);

            foreach ($this->_adp->models as $model) {
                $this->_pages[] = new PageObject($model);
            }
        }
        return $this->_pages ?: [];
    }

    /**
     * @param $id_slug
     * @return NewsItemObject
     */
    public function api_news_item($id_slug)
    {
        if (!isset($this->_news_item[$id_slug])) {
            $this->_news_item[$id_slug] = $this->findNewsItem($id_slug);
        }
        return $this->_news_item[$id_slug];
    }

    /**
     * @param array $options
     * @return NewsItemObject[]
     */
    public function api_news_items($options = [])
    {
        if (!isset($this->_news_items)) {
            $query = NewsItem::find()->sortDate();
            $this->_adp = new ActiveDataProvider([
                'query' => $query,
                'pagination' => isset($options['pagination']) ? $options['pagination'] : [],
            ]);
            foreach ($this->_adp->models as $model) {
                $this->_news_items[] = new NewsItemObject($model);
            }
        }
        return $this->_news_items ?: [];
    }

    /**
     * @return Country[]
     */
    public function api_countries()
    {
        return Data::cache($this->makeCacheKey(), function() {
            return Country::find()->all();
        });
    }

    /**
     * @param $id_slug
     * @return PageObject
     */
    protected function findPage($id_slug)
    {
        $result = Page::find()->where(['AND', ['OR', ['id' => $id_slug], ['slug' => $id_slug]], ['status' => 1]])->one();
        return isset($result) ? new PageObject($result) : null;
    }

    /**
     * @param $id_slug
     * @return NewsItemObject
     */
    protected function findNewsItem($id_slug)
    {
        $result = NewsItem::find()->where(['AND', ['OR', ['id' => $id_slug], ['slug' => $id_slug]], ['status' => 1]])->one();
        return isset($result) ? new NewsItemObject($result) : null;
    }
}