<?php

$installer = $this;

$installer->startSetup();

 $setup = new Mage_Sales_Model_Entity_Setup('core_setup');
 $setup->addAttribute('customer', 'ppmd_notify', array('type'=>'int'));


$installer->endSetup(); 