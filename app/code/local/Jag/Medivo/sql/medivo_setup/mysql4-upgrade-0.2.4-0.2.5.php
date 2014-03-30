<?php

$installer = $this;

$setup = new Mage_Sales_Model_Entity_Setup('core_setup');

$installer->startSetup();

$installer->run("

ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `lab_revenue` decimal(12,4) NULL;
ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `lab_revenue` decimal(12,4) NULL;

");



$setup->addAttribute('order', 'lab_revenue', array('type'=>'decimal','default'=>0));

$installer->endSetup(); 