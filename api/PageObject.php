<?php

namespace app\api;

use app\components\ApiObject;
use app\models\Page;

/**
 * Class PageObject
 * @package app\api
 *
 * @property Page $model
 * @method string getImageUrl()
 * @method string thumb($width, $height)
 */
class PageObject extends ApiObject
{

}