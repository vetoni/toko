<?php

namespace app\modules\install;

use Yii;
use yii\base\Module;

/**
 * Class InstallModule
 * @package app\modules\install
 *
 * @property boolean $installed
 */
class InstallModule extends Module
{
    /**
     * @var string
     */
    public $defaultRoute = 'step/first';

    /**
     * @var
     */
    private $_installed;

    /**
     * @return bool
     */
    public function getInstalled()
    {
        if ($this->_installed === null) {
            try {
                $prefix = Yii::$app->getDb()->tablePrefix;
                $this->_installed = Yii::$app->db->createCommand("SHOW TABLES LIKE '{$prefix}_%'")->query()->count() > 0 ? true : false;
            } catch (\Exception $e) {
                $this->_installed = false;
            }
        }

        return $this->_installed;
    }

    /**
     * @param $value
     */
    public function setInstalled($value)
    {
        $this->_installed = $value;
    }

    /**
     * @return $this
     */
    public function checkInstalled()
    {
        if (!$this->installed)
        {
            Yii::$app->urlManager->rules = [];

            if (substr(Yii::$app->request->pathInfo, 0, 7)  !== 'install') {
                Yii::$app->response->redirect(['/install']);
                Yii::$app->end();
            }
        }
    }
}