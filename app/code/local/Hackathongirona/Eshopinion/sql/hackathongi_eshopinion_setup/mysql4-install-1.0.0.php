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

/** @var Hackathongirona_Eshopinion_Model_Setup $installer */
$installer = $this;

$installer->startSetup();

$installer->getConnection()
    ->dropTable($installer->getTable('hackathongi_eshopinion/hackathongi_eshopinion'));

$table = $installer->getConnection()
    ->newTable($installer->getTable('hackathongi_eshopinion/hackathongi_eshopinion'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
            'identity' => true,
        ),
        'ID for primary key'
    )
    ->addColumn('shipment_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'nullable' => false,
        ),
        'Shipment ID has been send to API'
    )
    ->addColumn('created_time', Varien_Db_Ddl_Table::TYPE_DATETIME, null,
        array(
            'nullable' => true,
        ),
        'Row created time'
    )
    ->addColumn('update_time', Varien_Db_Ddl_Table::TYPE_DATETIME, null,
        array(
            'nullable' => true,
        ),
        'Row update time'
    );

$installer->getConnection()
    ->createTable($table);

/* Save date when module has been installed, for not send emails for prior shipped orders */
$date = new Zend_Date();
$installer->setConfigData('hackathongi_eshopinion/eshopinion_config/active_since', $date->toString(Varien_Date::DATETIME_INTERNAL_FORMAT));
$installer->setConfigData('hackathongi_eshopinion/eshopinion_config/last_cron', $date->toString(Varien_Date::DATETIME_INTERNAL_FORMAT));

$installer->endSetup();