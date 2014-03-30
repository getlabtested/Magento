<?php

$installer = $this;

$setup = new Mage_Sales_Model_Entity_Setup('core_setup');

$installer->startSetup();

$installer->run("

ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `com_activate` int(2) default 0;
ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `com_pwc_a` int(2) default 0;

");

$setup->addAttribute('order', 'com_activate', array('type'=>'int'));
$setup->addAttribute('order', 'com_pwc_a', array('type'=>'int'));

$installer->endSetup(); 