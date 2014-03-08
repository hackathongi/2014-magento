<?php
/**
 * Module for Eshopinion service
 *
 * @category    Hackathongirona
 * @package     Hackathongirona_Eshopinion
 * @author      Hackathon Girona 2014
 * @author      Rubén González <rbngzlv@gmail.com>
 * @license     http://opensource.org/licenses/MIT  The MIT License (MIT)
 */

class Hackathongirona_Eshopinion_Helper_Data extends Mage_Core_Helper_Abstract
{
    const CONFIG_PATH_MODULE_IS_ACTIVE = 'hackathongi_eshopinion/eshopinion_status/active';
    const CONFIG_PATH_ACTIVE_SINCE = 'hackathongi_eshopinion/eshopinion_config/active_since';
    const CONFIG_PATH_CRON_INTERVAL = 'hackathongi_eshopinion/eshopinion_config/cron_interval';
    const CONFIG_PATH_LAST_CRON = 'hackathongi_eshopinion/eshopinion_config/last_cron';
    const CONFIG_PATH_API_TOKEN = 'hackathongi_eshopinion/eshopinion_config/client_token';

    /**
     * Get if module is active
     *
     * @return string
     */
    public function isActive() {
        return $this->getLocalizedConfig(self::CONFIG_PATH_MODULE_IS_ACTIVE);
    }

    /**
     * Get last date when cron has executed
     *
     * @return mixed
     */
    public function getLastCronDate() {
        return $this->getLocalizedConfig(self::CONFIG_PATH_LAST_CRON);
    }

    /**
     * Get date when module has installed
     *
     * @return mixed
     */
    public function getInstallationDate() {
        return $this->getLocalizedConfig(self::CONFIG_PATH_ACTIVE_SINCE);
    }

    /**
     * Get date when module has installed
     *
     * @return mixed
     */
    public function getCronInterval() {
        return $this->getLocalizedConfig(self::CONFIG_PATH_CRON_INTERVAL);
    }

    /**
     * Get api client token
     *
     * @return mixed
     */
    public function getApiToken() {
        return $this->getLocalizedConfig(self::CONFIG_PATH_API_TOKEN);
    }

    /**
     * Get module config por current store
     *
     * @param $key string Config path to retrieve
     * @return mixed
     */
    private function getLocalizedConfig($key)
    {
        return Mage::getStoreConfig($key, Mage::app()->getStore());
    }
}