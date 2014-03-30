<?php

$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `pnm_pay_slip` varchar(255) NULL;
ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `pnm_pay_slip` varchar(255) NULL;

ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `pnm_order_identifier` varchar(255) NULL;
ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `pnm_order_identifier` varchar(255) NULL;

");

$setup = new Mage_Sales_Model_Entity_Setup('core_setup');
$setup->addAttribute('order', 'pnm_pay_slip', array('type'=>'varchar'));
$this->addAttribute('order', 'pnm_order_identifier', array('type' => 'varchar'));

$installer->endSetup(); 