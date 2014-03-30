<?php

$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn($this->getTable('sales_flat_quote'), 'order_state', 'varchar(4)');
$installer->getConnection()->addColumn($this->getTable('sales_flat_order'), 'order_state', 'varchar(4)');

$setup = new Mage_Sales_Model_Entity_Setup('core_setup');
$setup->addAttribute('order', 'order_state', array('type'=>'varchar'));

$installer->endSetup(); 