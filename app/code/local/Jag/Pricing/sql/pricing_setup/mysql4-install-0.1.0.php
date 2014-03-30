<?php

$installer = $this;

$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$setup->addAttribute('catalog_product', 'price_opt_one', array (
    'label'        => 'Price Opt 1',
    'type'          => 'decimal',
    'input'         => 'text',
    'unique'        => false,
    'required'      => false,
    'visible'    => true,
));

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$setup->addAttribute('catalog_product', 'price_opt_two', array (
    'label'        => 'Price Opt 2',
    'type'          => 'decimal',
    'input'         => 'text',
    'unique'        => false,
    'required'      => false,
    'visible'    => true,
));

$installer->endSetup(); 