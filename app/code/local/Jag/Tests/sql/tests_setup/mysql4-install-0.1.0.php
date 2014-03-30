<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('tests')};
CREATE TABLE {$this->getTable('tests')} (
  `tests_id` int(11) unsigned NOT NULL auto_increment,
  `order_id` int NULL default 0,
  `customer_id` int NULL default 0,
  `test_code` varchar(255) NOT NULL default '',
  `test_name` varchar(255) NOT NULL default '',
  `result` smallint(6) NOT NULL default '0',
  `updated_at` datetime NULL,
  PRIMARY KEY (`tests_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 