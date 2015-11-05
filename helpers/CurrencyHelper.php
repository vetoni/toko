<?php

namespace app\helpers;

use app\api\Shop;
use app\models\Currency;
use yii\base\InvalidConfigException;

/**
 * Class CurrencyHelper
 * @package app\helpers
 */
class CurrencyHelper
{
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
     * @param $value
     * @param null $currency
     * @return string
     * @throws InvalidConfigException
     */
    public static function format($value, $currency = null)
    {
        $currency = isset($currency) ? $currency : Shop::current_currency();
        $value = $value * Shop::currency($currency)->rate;
        return \Yii::$app->formatter->asCurrency($value, $currency);
    }
}