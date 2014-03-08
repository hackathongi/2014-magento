<?php
/**
 * Model for eshopinion notification
 *
 * @category    Hackathongirona
 * @package     Hackathongirona_Eshopinion
 * @author      Hackathon Girona 2014
 * @author      Rubén González <rbngzlv@gmail.com>
 * @license     http://opensource.org/licenses/MIT  The MIT License (MIT)
 */

class Hackathongirona_Eshopinion_Model_Mysql4_Eshopinion extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Constructor for send mails
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('hackathongi_eshopinion/hackathongi_eshopinion', 'id');
    }
}