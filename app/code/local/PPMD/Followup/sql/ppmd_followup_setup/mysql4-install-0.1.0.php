<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {`ppmd_followup`};
CREATE TABLE `ppmd_followup` (
  `followup_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `sku` varchar(64) NOT NULL,
  `scheduled_date` date NOT NULL,
  `scheduled_at` datetime NOT NULL,
  PRIMARY KEY (`followup_id`),
  KEY `scheduled_date` (`scheduled_date`)
) ENGINE=InnoDB");

$installer->endSetup();