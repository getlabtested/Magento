<?php

$installer = $this;
$installer->startSetup();

$setup = Mage::getModel('eav/entity_setup');

$setup->removeAttribute('catalog_product', 'is_std_test');

$setup->addAttribute('catalog_product', 'is_std_test', array(
    'type'          => 'int',
    'input'         => 'select',
    'label'         => 'Is Std Test',
    'source'        => 'catalog/product_attribute_source_boolean',
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'group'         => 'General',
    'backend'       => 'catalog/product_attribute_backend_boolean',
    'visible'       => true,
    'required'      => false,
    'user_defined'  => true,
    'system'        => 0,
    'default'       => 0,
    'visible_on_front' => false
));

$setup->updateAttribute('catalog_product', 'is_std_test', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);

$installer->endSetup();