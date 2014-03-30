<?php

$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `lost_order` int default 0;
ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `lost_order` int default 0;

");

$setup = new Mage_Sales_Model_Entity_Setup('core_setup');
$setup->addAttribute('order', 'lost_order', array('type'=>'int'));

$installer->endSetup(); 