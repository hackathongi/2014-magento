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

    /**
     * Get pending shipments for send to API
     *
     * @return array
     */
    public function shipmentsAfterLastCron() {

        // @todo: get shipments for send to api

        return '';
    }
}