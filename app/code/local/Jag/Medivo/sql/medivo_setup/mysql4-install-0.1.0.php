<?php

$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn($this->getTable('sales_flat_quote'), 'lab_id', 'char(20)');
$installer->getConnection()->addColumn($this->getTable('sales_flat_order'), 'lab_id', 'char(20)');

$setup = new Mage_Sales_Model_Entity_Setup('core_setup');
$setup->addAttribute('order', 'lab_id', array('type'=>'varchar'));

$installer->getConnection()->addColumn($this->getTable('sales_flat_quote'), 'lab_type', 'int(10)');
$installer->getConnection()->addColumn($this->getTable('sales_flat_order'), 'lab_type', 'int(10)');

$setup = new Mage_Sales_Model_Entity_Setup('core_setup');
$setup->addAttribute('order', 'lab_type', array('type'=>'int'));

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$setup->addAttribute('catalog_product', 'quest_testid', array (
    'label'        => 'Quest Test Code',
    'type'          => 'int',
    'input'         => 'text',
    'unique'        => true,
    'required'      => false,
    'visible'    => true,
));
$setup->addAttribute('catalog_product', 'labcorp_testid', array (
    'label'        => 'Lab Corp Code',
    'type'          => 'int',
    'input'         => 'text',
    'unique'        => true,
    'required'      => false,
    'visible'    => true,
));
$setup->addAttribute('catalog_product', 'athome_testid', array (
    'label'        => 'At Home Code',
    'type'          => 'int',
    'input'         => 'text',
    'unique'        => true,
    'required'      => false,
    'visible'    => true,
));

$installer->endSetup(); 