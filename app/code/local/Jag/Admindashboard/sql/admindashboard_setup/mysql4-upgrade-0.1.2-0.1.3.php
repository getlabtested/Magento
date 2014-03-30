<?php

$installer = $this;

$installer->startSetup();

$installer->run("
 
 ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `ppmd_call_reason` int NULL;
 ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `ppmd_call_reason` int NULL;
  
  ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `ppmd_affiliate` int NULL;
 ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `ppmd_affiliate` int NULL;
  
  ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `ppmd_rep` int NULL;
 ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `ppmd_rep` int NULL;
  
 ");

 $setup = new Mage_Sales_Model_Entity_Setup('core_setup');
 $setup->addAttribute('order', 'ppmd_call_reason', array('type'=>'int'));
 
  $setup = new Mage_Sales_Model_Entity_Setup('core_setup');
 $setup->addAttribute('order', 'ppmd_affiliate', array('type'=>'int'));
 
 $setup = new Mage_Sales_Model_Entity_Setup('core_setup');
 $setup->addAttribute('order', 'ppmd_rep', array('type'=>'int'));
 
  // $setup = new Mage_Sales_Model_Entity_Setup('core_setup');
 // $setup->addAttribute('customer', 'ppmd_notify_type', array('type'=>'int'));


$installer->endSetup(); 
