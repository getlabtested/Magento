<?php

class Jag_Landingpage_Helper_Data extends Mage_Core_Helper_Abstract
{
    const LP_TO_SKU_STRING_CONFIG_BASE = 'landing_pages/skus/';

    /*
     * Path is relative to app\design\frontend\enterprise\getlabtested\template\landingpage\
     */
    public function getProductIdByLpPath($relative_path)
    {
        $config_path = self::LP_TO_SKU_STRING_CONFIG_BASE.$relative_path;
        $sku = Mage::getStoreConfig($config_path);
        $product_id = Mage::getModel('catalog/product')->getIdBySku($sku);

        return $product_id;
    }
}
