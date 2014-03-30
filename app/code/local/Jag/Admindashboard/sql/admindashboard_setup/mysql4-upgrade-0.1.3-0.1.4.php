<?php

$installer = $this;

$installer->startSetup();

$installer->run("
 
 ALTER TABLE `{$this->getTable('sales_flat_order_grid')}` ADD `method` varchar(255) not null;
  
 ");


$installer->endSetup(); 
