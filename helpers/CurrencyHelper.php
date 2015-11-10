<?php

namespace app\helpers;

use app\models\Currency;
use app\modules\user\models\Country;
use app\modules\user\models\User;
use yii\base\InvalidConfigException;

/**
 * Class CurrencyHelper
 * @package app\helpers
 */
class CurrencyHelper
{
    /**
     * @var array
     */
    protected static $_currencies;

    /**
     * @return Currency[]
     */
    public static function all()
    {
        if (!isset(static::$_currencies)) {
            /** @var Currency[] $list */
            static::$_currencies = Currency::find()->all();
        }
        return static::$_currencies;
    }

    /**
     * @return Currency
     */
    public static function current()
    {
        $code = Data::load('currency', function() {
            /** @var User $user */
            $user = \Yii::$app->user->identity;
            return \Yii::$app->user->isGuest
                ? static::getDefault()->code
                : Country::findOne($user->country_id)->currency_code;
        });
        return static::get($code);
    }

    /**
     * @param string $code
     */
    public static function change($code)
    {
        Data::save('currency', $code);
    }

    /**
     * @return Currency
     */
    public static function getDefault()
    {
        return static::findCurrency('is_default', true);
    }

    /**
     * @param $code
     * @return Currency
     */
    public static function get($code)
    {
        return static::findCurrency('code', $code);
    }

    /**
     * Converts price value to the specified currency.
     * Value should be passed in default currency.
     * If code argument is not set current currency will be used.
     * @param $value
     * @param null $code
     * @return float
     */
    public static function convert($value, $code = null)
    {
        $currency = isset($code) ? static::get($code) : static::current();
        return $currency->rate * $value;
    }

    /**
     * @param $value
     * @param $code
     * @return string
     * @throws InvalidConfigException
     */
    public static function format($value, $code = null)
    {
        $currency = isset($code) ? static::get($code) : static::current();
        return \Yii::$app->formatter->asCurrency($currency->rate * $value, $currency->code);
    }

    /**
     * @throws InvalidConfigException
     */
    public static function refreshRates()
    {
        /** @var Currency $defaultCurrency */
        $defaultCurrency = Currency::findOne(['is_default' => 1]);
        if (!$defaultCurrency) {
            throw new InvalidConfigException('Default currency is not set.');
        }
        /** @var Currency[] $currencies */
        $currencies = Currency::find()->all();
        foreach ($currencies as $currency)
        {
            if ($currency->code == $defaultCurrency->code) {
                $currency->rate = 1;
            }
            else {
                $url = 'http://finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s='. $defaultCurrency->code . $currency->code .'=X';
                $handle = @fopen($url, 'r');
                $result = fgets($handle, 4096);
                fclose($handle);
                $currencyData = explode(',', $result);
                $currency->rate = $currencyData[1];
            }
            $currency->save();
        }
    }

    /**
     * @param $attrName
     * @param $attrValue
     * @return Currency
     */
    protected static function findCurrency($attrName, $attrValue)
    {
        $currencies = static::all();
        foreach ($currencies as $currency) {
            if ($currency->{$attrName} == $attrValue) {
                return $currency;
            }
        }
        throw new \InvalidArgumentException("Currency '{$attrName}={$attrValue}' not found");
    }
}