<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('prescriptions')};
CREATE TABLE {$this->getTable('prescriptions')} (
  `prescriptions_id` int(11) unsigned NOT NULL auto_increment,
  `order_id` int(11) unsigned NOT NULL,
  `customer_id` int(11) unsigned NOT NULL,
  `customer_name` varchar(255) NOT NULL default '',
  `customer_phone` varchar(255) NOT NULL default '',
  `pharmacy_phone` varchar(255) NOT NULL default '',
  `allergies` varchar(255) NOT NULL default '',
  `cur_meds` varchar(255) NOT NULL default '',
  `cur_otc_meds` varchar(255) NOT NULL default '',
  `med_history` varchar(255) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`prescriptions_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 
