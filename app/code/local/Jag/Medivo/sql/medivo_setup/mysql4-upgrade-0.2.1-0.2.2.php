<?php

$installer = $this;

$setup = new Mage_Sales_Model_Entity_Setup('core_setup');

$setup->removeAttribute(5, 'affiliate_id');

$installer->startSetup();

$installer->run("

ALTER TABLE `{$this->getTable('sales_flat_quote')}` DROP COLUMN `affiliate_id`;
ALTER TABLE `{$this->getTable('sales_flat_order')}` DROP COLUMN `affiliate_id`;

ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `affiliate_id` varchar(200) NULL;
ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `affiliate_id` varchar(200) NULL;

");



$setup->addAttribute('order', 'affiliate_id', array('type'=>'varhcar'));

$installer->endSetup(); 