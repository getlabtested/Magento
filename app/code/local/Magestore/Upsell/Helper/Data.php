<?php

class Magestore_Upsell_Helper_Data
{
    const UPSELL_INDEX_ROUTE_CONFIG = 'upsell_routes/upsell_index';
    const UPSELL_INDEX_URL_CONFIG = 'upsell_routes/upsell_url';
    const CHECKOUTPAGE_INDEX_ROUTE_CONFIG = 'upsell_routes/checkout_page_index';
    const INTERMEDIATE_CHECKOUT_ROUTES_CONFIG = 'upsell_routes/intermediate_checkout_pages';
    const NON_INDIVIDUAL_UPSELLS_CONFIG = 'upsell_products/not_to_display_as_individuals';
    const STORES_WITH_UPSELL_ACTIVE_CONIG = 'upsell_stores/active';

    protected $_upsell_products_by_cart = null;

    public function getUpsellIndexRoute()
    {
        return Mage::getStoreConfig(self::UPSELL_INDEX_ROUTE_CONFIG);
    }

    public function getUpsellIndexUrl()
    {
        return Mage::getStoreConfig(self::UPSELL_INDEX_URL_CONFIG);
    }

    public function getCheckoutPageIndexRoute()
    {
        return Mage::getStoreConfig(self::CHECKOUTPAGE_INDEX_ROUTE_CONFIG);
    }

    public function getIntermediateCheckoutRoutes()
    {
        return array_keys(Mage::getStoreConfig(self::INTERMEDIATE_CHECKOUT_ROUTES_CONFIG));
    }

    public function getOnlyIndivdualUpsellProducts()
    {
        $non_individual_upsells = array_keys(Mage::getStoreConfig(self::NON_INDIVIDUAL_UPSELLS_CONFIG));

        $all_upsell_products = $this->getAllUpsellProducts();
        $all_upsell_products->addAttributeToFilter('sku', array('nin' => $non_individual_upsells));

        return $all_upsell_products;
    }

    public function getUpsellProductsByCart()
    {
        if (is_null($this->_upsell_products_by_cart))
        {
            try
            {
                $upsell_products_set = array();

                $quote = Mage::helper('checkout/cart')->getQuote();

                // This should never occur, but account for the case
                if (!is_object($quote))
                {
                    $this->_upsell_products_by_cart = array();
                    return $this->_upsell_products_by_cart;
                }

                $quote_items = $quote->getItemsCollection();

                $cart_products_ids = array();

                foreach ($quote_items as $item)
                {
                    $product = Mage::getModel('catalog/product')->load($item->getProductId());
                    $cart_products_ids[] = $item->getProductId();
                    $upsell_products = $product->getUpSellProducts();

                    if (!is_array($upsell_products))
                    {
                        continue;
                    }

                    foreach ($upsell_products as $upsell)
                    {
                        if (!is_object($upsell))
                        {
                            continue;
                        }
                        $upsell_products_set[$upsell->getEntityId()] = $upsell->load($upsell->getEntityId());
                    }
                }

                // Don't show any products which are already in the cart
                foreach($cart_products_ids as $cart_product_id)
                {
                    if (isset($upsell_products_set[$cart_product_id]))
                    {
                        unset($upsell_products_set[$cart_product_id]);
                    }
                }

                $this->_upsell_products_by_cart = $upsell_products_set;
            }
            catch(Exception $e)
            {
                Mage::log("Error Occurred while trying to retrieve upsell products.");
                Mage::log($e->getMessage());

                return array();
            }
        }

        return $this->_upsell_products_by_cart;
    }

    public function getAllUpsellProducts()
    {
        $upsell_products = Mage::getModel('catalog/product')
            ->getCollection()
            ->addAttributeToFilter('is_upsell_product', array('neq' => 0))
            ->addAttributeToSelect('description')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('price')
            ->addAttributeToSelect('upsell_old_price')
            ->addAttributeToSort('name');

        return $upsell_products;
    }

    public function getWellnessPackageUpsell()
    {
        $wellness_package = Mage::getModel('catalog/product')
            ->getCollection()
            ->addAttributeToFilter('sku', 'complete-checkup-lab')
            ->addAttributeToSelect('description')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('price')
            ->addAttributeToSelect('upsell_old_price')
            ->addAttributeToSort('name');

        return $wellness_package->getFirstItem();
    }

    public function isUpsellActiveForStore($store_code)
    {
        $upsell_active_stores = Mage::getStoreConfig(self::STORES_WITH_UPSELL_ACTIVE_CONIG);
        if (!is_array($upsell_active_stores))
        {
            return false;
        }

        return in_array($store_code, array_keys($upsell_active_stores));
    }
}
