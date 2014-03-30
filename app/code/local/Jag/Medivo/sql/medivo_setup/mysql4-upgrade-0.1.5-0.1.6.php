<?php

$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `product_line` int(2) NULL DEFAULT 0;
ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `product_line` int(2) NULL DEFAULT 0;

");

$setup = new Mage_Sales_Model_Entity_Setup('core_setup');
$setup->addAttribute('order', 'product_line', array('type'=>'int'));

$installer->endSetup(); 