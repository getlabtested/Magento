<?php

$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn($this->getTable('sales_flat_quote'), 'lab_zip', 'int(10)');
$installer->getConnection()->addColumn($this->getTable('sales_flat_order'), 'lab_zip', 'int(10)');

$setup = new Mage_Sales_Model_Entity_Setup('core_setup');
$setup->addAttribute('order', 'lab_zip', array('type'=>'int'));

$installer->endSetup(); 