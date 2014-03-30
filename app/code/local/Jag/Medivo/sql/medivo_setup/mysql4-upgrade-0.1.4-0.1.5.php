<?php

$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `lab_code` varchar(20) NULL;
ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `lab_code` varchar(20) NULL;

");

$setup = new Mage_Sales_Model_Entity_Setup('core_setup');
$setup->addAttribute('order', 'lab_code', array('type'=>'varchar'));

$installer->endSetup(); 