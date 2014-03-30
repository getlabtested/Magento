<?php

$installer = $this;

$setup = new Mage_Sales_Model_Entity_Setup('core_setup');

$setup->removeAttribute(5, 'ppmd_affiliate');

$installer->startSetup();

$installer->run("

ALTER TABLE `{$this->getTable('sales_flat_quote')}` DROP COLUMN `ppmd_affiliate`;
ALTER TABLE `{$this->getTable('sales_flat_order')}` DROP COLUMN `ppmd_affiliate`;

ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `ppmd_affiliate` varchar(200) NULL;
ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `ppmd_affiliate` varchar(200) NULL;

");



$setup->addAttribute('order', 'ppmd_affiliate', array('type'=>'varhcar'));

$installer->endSetup(); 