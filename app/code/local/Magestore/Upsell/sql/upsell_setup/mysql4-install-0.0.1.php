<?php

$installer = $this;
$installer->startSetup();

$setup = Mage::getModel('eav/entity_setup');

$setup->removeAttribute('catalog_product', 'is_upsell_product');
$setup->removeAttribute('catalog_product', 'upsell_old_price');

$setup->addAttribute('catalog_product', 'is_upsell_product', array(
    'type'          => 'int',
    'input'         => 'select',
    'label'         => 'Is Upsell Product',
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

$setup->addAttribute('catalog_product', 'upsell_old_price', array(
    'group'         => 'General',
    'type'          => 'text',
    'input'         => 'text',
    'label'         => 'Old Upsell Price',
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'       => true,
    'required'      => false,
    'user_defined'  => true,
    'default'       => '',
    'visible_on_front' => false,
    'note' => 'This is the price which will be shown on the product upsell page',
));

$setup->updateAttribute('catalog_product', 'is_upsell_product', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$setup->updateAttribute('catalog_product', 'upsell_old_price', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);

$installer->endSetup();