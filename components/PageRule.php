<?php

namespace app\components;
use app\api\Shop;
use yii\base\Object;
use yii\web\UrlRuleInterface;

/**
 * Class PageRule
 * @package app\components
 */
class PageRule extends Object implements UrlRuleInterface
{
    /**
     * @param \yii\web\UrlManager $manager
     * @param \yii\web\Request $request
     * @return array|bool
     */
    public function parseRequest($manager, $request)
    {
        $page = Shop::page($request->pathInfo);
        if ($page) {
            return ["page/{$page->model->type}", ['slug' => $page->model->slug]];
        }
        return false;
    }

    /**
     * @param \yii\web\UrlManager $manager
     * @param string $route
     * @param array $params
     * @return bool|string
     */
    public function createUrl($manager, $route, $params)
    {
        if ($route === 'page/show' || $route === 'page/list') {

            $id_slug = null;

            if (isset($params['slug'])) {
                $id_slug = $params['slug'];
            }

            if (isset($params['id'])) {
                $id_slug = $params['id'];
            }

            $page = Shop::page($id_slug);

            if ($page) {
                return $page->model->slug;
            }
        }
        return false;
    }
}