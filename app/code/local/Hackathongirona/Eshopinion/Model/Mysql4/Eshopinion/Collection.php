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

class Hackathongirona_Eshopinion_Model_Mysql4_Eshopinion_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    /**
     * constructor for eshopinion notifications collection
     *
     * @return void
     */
    public function _construct() {

        parent::_construct();
        $this->_init('hackathongi_eshopinion/eshopinion');
    }
}