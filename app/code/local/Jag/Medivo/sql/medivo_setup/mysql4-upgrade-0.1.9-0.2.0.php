<?php

$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `affiliate_id` int default 0;
ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `affiliate_id` int default 0;

");

$setup = new Mage_Sales_Model_Entity_Setup('core_setup');
$setup->addAttribute('order', 'affiliate_id', array('type'=>'int'));

$installer->endSetup(); 