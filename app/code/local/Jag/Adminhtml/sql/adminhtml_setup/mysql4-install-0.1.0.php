<?php

$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn($this->getTable('sales_flat_quote'), 'follow_up', 'int(5)');
$installer->getConnection()->addColumn($this->getTable('sales_flat_order'), 'follow_up', 'int(5)');

$setup = new Mage_Sales_Model_Entity_Setup('core_setup');
$setup->addAttribute('order', 'follow_up', array('type'=>'int'));

$installer->endSetup(); 