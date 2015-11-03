<?php
namespace app\helpers;

use Yii;
use yii\helpers\FileHelper;
use yii\web\ServerErrorHttpException;

class Migrations
{
    private static $_console;
    public static $logFile;
    public static $logFileHandler;

    public static function console()
    {
        if(!self::$_console)
        {
            $logsPath = Yii::getAlias('@runtime/logs');
            if(!FileHelper::createDirectory($logsPath, 0777)){
                throw new ServerErrorHttpException('Cannot create `'.$logsPath.'`. Please check write permissions.');
            }

            self::$logFile = $logsPath . DIRECTORY_SEPARATOR . 'console.log';
            self::$logFileHandler = fopen(self::$logFile, 'w+');

            defined('STDIN') or define( 'STDIN',  self::$logFileHandler);
            defined('STDOUT') or define( 'STDOUT',  self::$logFileHandler);

            $oldApp = Yii::$app;

            $consoleConfigFile = Yii::getAlias('@app/config/console.php');

            if(!file_exists($consoleConfigFile) || !is_array(($consoleConfig = require($consoleConfigFile)))){
                throw new ServerErrorHttpException('Cannot find `'.Yii::getAlias('@app/config/console.php').'`. Please create and configure console config.');
            }

            self::$_console = new \yii\console\Application($consoleConfig);

            Yii::$app = $oldApp;
        } else {
            ftruncate(self::$logFileHandler, 0);
        }

        return self::$_console;
    }

    public static function run()
    {
        ob_start();

        $prefix = Yii::$app->getDb()->tablePrefix;
        self::console()->runAction('migrate', ['migrationPath' => '@app/migrations/', 'migrationTable' => "{$prefix}migration", 'interactive' => false]);

        $result = file_get_contents(self::$logFile) . "\n" . ob_get_clean();

        Yii::$app->cache->flush();

        return $result;
    }
}