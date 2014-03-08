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
    const CONFIG_PATH_API_TOKEN = 'hackathongi_eshopinion/eshopinion_config/token';

    /**
     * Get if module is active
     *
     * @return string
     */
    public function isActive() {
        return $this->getLocalizedConfig(self::CONFIG_PATH_MODULE_IS_ACTIVE);
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