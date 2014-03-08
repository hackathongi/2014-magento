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
    const API_URL = 'http://api-test.eshopinion.com/orders';

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

            $url = self::API_URL;

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

        $products = array();
        $ordered_items = $order->getAllItems();
        foreach($ordered_items as $item){
            $products[] = array(
                'code' => $item->getItemId(),
                'name' => $item->getName(),
                'ean' => $item->getSku,
            );;
        }

        $json = array(
            'token' => $this->getHelper()->getApiToken(),
            'order' => array(
                'id' => $order->getRealOrderId(),
                'date' => $order->getCreatedAt(),
                'products' => $products
            ),
            'client' => array(
                'email' => $order->getCustomerEmail(),
                'name' => $order->getCustomerFirstname(),
                'surname' => $order->getCustomerLastname(),
                'language' => Mage::app()->getLocale()->getLocaleCode()
            )
        );

        try{
            $result = $this->sendPOST($url, json_encode($json));
            if (strstr($result, 'HTTP/1.1 200')) {
                $model = Mage::getModel('hackathongi_eshopinion/eshopinion');
                $model->addData(array(
                    'shipment_id' => $shipmentID,
                    'created_time' => now(),
                    'update_time' => now()
                ));

                $model->save();
            }
        } catch (Exception $e) {

            error_log('eShopinion: ' . $e->getMessage());
        }
    }

    private function sendPOST($url, $post = '', $curlParameters = array()) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'eShoppinion Bot');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($curl, CURLOPT_PROXY, '127.0.0.1:9050');
        //curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if (!empty($curlParameters)) {
            foreach ($curlParameters as $key => $value) {
                curl_setopt($ch, $key, $value);
            }
        }

        $html = curl_exec($ch);

        if (curl_errno($ch)) {
            print curl_error($ch);
        }

        curl_close($ch);

        return $html;
    }
}