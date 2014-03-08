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
    const API_URL = 'http://api-test.eshopinion.com/shops/order/{{token}}';

    /** @var Hackathongirona_Eshopinion_Helper_Data  $helper */
    private $helper;

    /**
     * Get Helper
     *
     * @return Hackathongirona_Eshopinion_Helper_Data
     */
    private function getHelper() {
        if(!$this->helper) {
            $this->helper = Mage::helper('hackathongi_eshopinion');
        }

        return $this->helper;
    }


    public function sendShipmentsToApi() {
        /** @var Hackathongirona_Eshopinion_Model_Eshopinion $model */
        $model = Mage::getModel('hackathongi_eshopinion/eshopinion');

        $latestShipments = $model->shipmentsAfterLastCron();

        if ($this->getHelper()->isActive() && $latestShipments) {
            $url = str_replace('{{token}}', $this->getHelper()->getApiToken(), self::API_URL);

            foreach($latestShipments as $shipment) {
                $shipment = Mage::getModel('sales/order_shipment')->load($shipment);
                $order = Mage::getModel('sales/order')->load($shipment->getData('order_id'));

                $this->sendOrderToAPI($url, $order, $shipment->getData('entity_id'));
            }

            // Update latest cron date
            $date = new Zend_Date();
            Mage::getModel('core/config')->saveConfig(Hackathongirona_Eshopinion_Helper_Data::CONFIG_PATH_LAST_CRON, $date->toString(Varien_Date::DATETIME_INTERNAL_FORMAT));
        }
    }

    public function sendOrderToAPI($url, $order, $shipmentID) {
        /** @var Mage_Sales_Model_Order  $order */
        $id = $order->getRealOrderId();
        $email = $order->getCustomerEmail();

        // @todo : send data to api

        if(true) {
            $model = Mage::getModel('hackathongi_eshopinion/eshopinion');
            $model->addData(array(
                'shipment_id' => $shipmentID,
                'created_time' => now(),
                'update_time' => now()
            ));

            $model->save();
        }
    }
}