<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('callcenter')};
CREATE TABLE {$this->getTable('callcenter')} (
  `callcenter_id` int(11) unsigned NOT NULL auto_increment,
  `customer_id` int(11) unsigned NOT NULL,
  `quote_id` int(11) unsigned NOT NULL,
  `order_id` int(11) unsigned NOT NULL,
  `reason_id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`callcenter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 
