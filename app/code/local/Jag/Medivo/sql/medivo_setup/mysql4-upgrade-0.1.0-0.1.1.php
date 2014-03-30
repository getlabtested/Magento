<?php

$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn($this->getTable('sales_flat_quote'), 'order_type', 'int(10)');
$installer->getConnection()->addColumn($this->getTable('sales_flat_order'), 'order_type', 'int(10)');

$setup = new Mage_Sales_Model_Entity_Setup('core_setup');
$setup->addAttribute('order', 'order_type', array('type'=>'int'));

$installer->endSetup(); 