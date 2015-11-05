<?php

namespace app\api;

use app\components\Api;
use app\helpers\Data;
use app\models\Currency;
use app\models\Page;
use app\modules\user\models\Country;
use app\modules\user\models\User;
use yii\base\InvalidConfigException;

/**
 * Class Shop
 * @package app\api
 *
 * @method static PageObject page(string $id_slug)
 * @method static Currency currency(string $id_code)
 * @method static string current_currency($code = null)
 * @method static string default_currency()
 * @method static Country country($code)
 * @method static Currency[] currencies()
 */
class Shop extends Api
{
    /**
     * @var array
     */
    protected $_currencies;

    /**
     * @return Currency[]
     */
    public function api_currencies()
    {
        if (!isset($this->_currencies)) {
            /** @var Currency[] $list */
            $list = Currency::find()->all();
            foreach ($list as $currency) {
                $this->_currencies[$currency->code] = $currency;
            }
        }
        return $this->_currencies;
    }

    /**
     * @param $code
     * @return Currency
     * @throws InvalidConfigException
     */
    public function api_currency($code)
    {
        $currencies = $this->api_currencies();
        foreach ($currencies as $currency) {
            if ($currency->code == $code) {
                return $currency;
            }
        }
        throw new InvalidConfigException('Default currency not set.');
    }

    /**
     * @return string
     * @throws InvalidConfigException
     */
    public function api_default_currency()
    {
        $currencies = $this->api_currencies();
        foreach ($currencies as $currency) {
            if ($currency->is_default) {
                return $currency->code;
            }
        }
        throw new InvalidConfigException('Default currency not set.');
    }


    /**
     * Gets or sets (if code argument is specified) the current currency.
     * @param string $code
     * @return string
     * @throws InvalidConfigException
     */
    public function api_current_currency($code = null)
    {
        if (!isset($code)) {
            $code = Data::load('currency');
            if (!$code) {
                if (!\Yii::$app->user->isGuest) {
                    /** @var User $user */
                    $user = \Yii::$app->user->identity;
                    $country = $this->api_country($user->country_id);
                    $code = $country->currency_code;
                }
                else {
                    $code = $this->api_default_currency();
                }
                Data::save('currency', $code);
            }
        }
        else {
            Data::save('currency', $code);
        }
        return $code;
    }

    /**
     * @param $code
     * @return Country
     */
    public function api_country($code)
    {
        return Data::cache($this->makeCacheKey($code), function() use ($code) {
            return $this->findCountry($code);
        });
    }

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
     * @param $id_slug
     * @return PageObject|null
     */
    protected function findPage($id_slug)
    {
        $result = Page::find()->where(['AND', ['OR', ['id' => $id_slug], ['slug' => $id_slug]], ['status' => 1]])->one();
        return isset($result) ? new PageObject($result) : null;
    }

    /**
     * @param $id
     * @return Country
     */
    protected function findCountry($id)
    {
        return Country::findOne($id);
    }

    /**
     * @param $code
     * @return Currency
     */
    protected function findCurrency($code)
    {
        return Currency::find()->where(['code' => $code])->one();
    }
}