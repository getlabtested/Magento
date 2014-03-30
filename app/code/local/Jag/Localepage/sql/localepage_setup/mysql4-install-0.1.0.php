<?php

$installer = $this;

$installer->startSetup();

$installer->run("


CREATE TABLE {$this->getTable('localepage')} (
  `localepage_id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `url_key` varchar(255) NOT NULL DEFAULT '',
  `title_tag` varchar(255) NOT NULL DEFAULT '',
  `meta_keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  `values` text NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `template_id` int(15) NOT NULL,
  `images` text NOT NULL,
  PRIMARY KEY (`localepage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

    ");

$installer->endSetup(); 