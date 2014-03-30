<?php

$installer = $this;

$installer->startSetup();

$installer->run("
 
 ALTER TABLE `{$this->getTable('sales_flat_quote')}` ADD `ppmd_lab` TEXT NULL;
 ALTER TABLE `{$this->getTable('sales_flat_order')}` ADD `ppmd_lab` TEXT NULL;
  
 ");

 $setup = new Mage_Sales_Model_Entity_Setup('core_setup');
 $setup->addAttribute('order', 'ppmd_lab', array('type'=>'text'));


$installer->endSetup(); 
