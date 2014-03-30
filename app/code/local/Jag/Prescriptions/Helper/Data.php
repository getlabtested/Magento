<?php

class Jag_Prescriptions_Helper_Data extends Mage_Core_Helper_Abstract
{
    const PRESCRIPTION_SKU_CONFIG_PATH = 'prescription/sku';

    public function clearScriptsFromQuote($quote)
    {
        $prescription_sku = $this->getPrescriptionsSku();

        foreach ($quote->getAllItems() as $item)
        {
            $product_id = $item->getProductId();
            $product = Mage::getModel('catalog/product')->load($product_id);

            if (!strcmp($prescription_sku, $product->getSku()))
            {
                $quote->removeItem($item->getId());
                // Also remove the item from the Mage::getSingleton('core/session')->getCartArr();
                $cart_array = Mage::getSingleton('core/session')->getCartArr();
                $cart_array_index = array_search($product_id, $cart_array);

                if ($cart_array_index !== FALSE)
                {
                    unset($cart_array[$cart_array_index]);
                }
                Mage::getSingleton('core/session')->setCartArr($cart_array);
            }
        }

        return true;
    }

    public function getPrescriptionsSku()
    {
        return Mage::getStoreConfig(self::PRESCRIPTION_SKU_CONFIG_PATH);
    }
}