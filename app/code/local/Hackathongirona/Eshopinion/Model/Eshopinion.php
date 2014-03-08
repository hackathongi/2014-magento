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

class Hackathongirona_Eshopinion_Model_Eshopinion extends Mage_Core_Model_Abstract
{

    public function _construct() {

        parent::_construct();
        $this->_init('hackathongi_eshopinion/eshopinion');
    }

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

    /**
     * Get pending shipments for send to API
     *
     * @return array
     */
    public function shipmentsAfterLastCron() {

        // Last time that cron has executed
        $from = $this->getHelper()->getLastCronDate();
        $fromSeconds = strtotime($from);

        // Interval set in config
        $interval = $this->getHelper()->getCronInterval();

        if (is_null($interval) || $interval < 0) {
            $interval = 0;
        }

        // Days to seconds
        $interval = $interval * 86400;

        // To date
        $now = new Zend_Date();
        $nowSeconds = $now->get();

        if(($nowSeconds - $fromSeconds) < $interval) {
            return false;
        }

        $to = date('Y-m-d H:i:s', ($nowSeconds));

        $alreadySent = array();

        $collection = $this->getCollection();

        foreach($collection->getItems() as $done) {
            $alreadySent[] = $done->getShipmentId();
        }

        $shipmentsCollection = Mage::getResourceModel('sales/order_shipment_collection');

        if(!empty($alreadySent)) {
            $shipmentsCollection->addAttributeToFilter('entity_id', array('nin' => $alreadySent));
        }

        $shipmentsCollection->addAttributeToFilter('created_at', array('from' => $from, 'to' => $to));
        $shipmentsCollection->load();

        if (!$shipmentsCollection) {
            return false;
        }

        return $shipmentsCollection->getAllIds();
    }
}