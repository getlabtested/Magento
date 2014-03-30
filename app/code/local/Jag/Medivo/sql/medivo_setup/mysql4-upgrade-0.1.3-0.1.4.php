<?php

$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `ppmd_provider` INT(5) NULL DEFAULT 0;
ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `ppmd_provider` INT(5) NULL DEFAULT 0;

ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `ppmd_order_id` varchar(50) NULL;
ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `ppmd_order_id` varchar(50) NULL;

ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `ppmd_cust_id` varchar(50) NULL;
ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `ppmd_cust_id` varchar(50) NULL;

ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `ppmd_cust_acct` varchar(50) NULL;
ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `ppmd_cust_acct` varchar(50) NULL;

ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `ppmd_cust_conf` varchar(50) NULL;
ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `ppmd_cust_conf` varchar(50) NULL;

ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `ppmd_status` INT(5) NULL DEFAULT 0;
ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `ppmd_status` INT(5) NULL DEFAULT 0;


");

$setup = new Mage_Sales_Model_Entity_Setup('core_setup');
$setup->addAttribute('order', 'ppmd_provider', array('type'=>'int'));
$setup->addAttribute('order', 'ppmd_order_id', array('type'=>'varchar'));
$setup->addAttribute('order', 'ppmd_cust_id', array('type'=>'varchar'));
$setup->addAttribute('order', 'ppmd_cust_acct', array('type'=>'varchar'));
$setup->addAttribute('order', 'ppmd_cust_conf', array('type'=>'varchar'));
$setup->addAttribute('order', 'ppmd_status', array('type'=>'int'));

$installer->endSetup(); 