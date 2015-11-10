<?php

namespace app\api;

use app\components\Api;
use app\helpers\Data;
use app\models\Page;
use app\modules\user\models\Country;

/**
 * Class Shop
 * @package app\api
 *
 * @method static PageObject page($id_slug)
 * @method static Country[] countries()
 */
class Shop extends Api
{
    /**
     * @param $id_slug
     * @return PageObject
     */
    public function api_page($id_slug)
    {
        return Data::cache($this->makeCacheKey($id_slug), function() use ($id_slug) {
            return $this->findPage($id_slug);
        });
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
     * @return PageObject|null
     */
    protected function findPage($id_slug)
    {
        $result = Page::find()->where(['AND', ['OR', ['id' => $id_slug], ['slug' => $id_slug]], ['status' => 1]])->one();
        return isset($result) ? new PageObject($result) : null;
    }
}