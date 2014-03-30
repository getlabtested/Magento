<?php

$installer = $this;

$setup = new Mage_Sales_Model_Entity_Setup('core_setup');

$installer->startSetup();

$installer->run("

ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `has_script` int(2) default 0;
ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `has_script` int(2) default 0;

");


$setup->addAttribute('order', 'has_script', array('type'=>'int'));

$installer->endSetup(); 