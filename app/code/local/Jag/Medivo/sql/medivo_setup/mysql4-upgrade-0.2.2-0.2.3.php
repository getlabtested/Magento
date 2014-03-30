<?php

$installer = $this;

$setup = new Mage_Sales_Model_Entity_Setup('core_setup');

$installer->startSetup();

$installer->run("

ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `pstring` varchar(255) NULL;
ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `pstring` varchar(255) NULL;

");



$setup->addAttribute('order', 'pstring', array('type'=>'varhcar'));

$installer->endSetup(); 