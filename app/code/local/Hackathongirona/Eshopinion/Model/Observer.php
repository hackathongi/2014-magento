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

class Hackathongirona_Eshopinion_Model_Observer
{
    /**
     * Get Helper
     *
     * @return Hackathongirona_Eshopinion_Helper_Data
     */
    public function getHelper() {
        return Mage::helper('hackathongi_eshopinion');
    }


    public function sendShipmentsToApi() {
        /** @var Hackathongirona_Eshopinion_Model_Eshopinion $model */
        $model = Mage::getModel('hackathongi_eshopinion/eshopinion');

        if ($this->isActive() && $shipmentIds = $model->checkShippings()) {
            $this->_sendTrustedRatingMails($shipmentIds);
        }
    }
}