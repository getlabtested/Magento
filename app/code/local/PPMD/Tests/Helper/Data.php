<?php

class PPMD_Tests_Helper_Data extends Mage_Core_Helper_Abstract
{
    const ROOT_TEST_CATEGORY_URL_KEY_CONFIG = 'ppmd_tests/root_test_category/url_key';
    const TEST_PAGE_PATH_CONFIG_PATH = 'ppmd_tests/test_page_path';
    const LAB_SELECTION_VENDORS_CONFIG_PATH = 'ppmd_tests/vendors_requiring_lab_selection';

    const SLASH_BIRTHDAY_REGEX = '#[0-9]{1,2}/[0-9]{1,2}/[0-9]{4}#';

    public function validateSlashBirthday($birthday_string)
    {
        return $this->getRegexResult(self::SLASH_BIRTHDAY_REGEX, $birthday_string);
    }

    public function getRegexResult($pattern, $subject)
    {
        $matches = array();
        $result = preg_match($pattern, $subject, $matches);
        if ($result)
        {
            return reset($matches);
        }
        return false;
    }
    
    public function submitVendorRequests($observer)
    {
        $orderId = $observer->getEvent()->getOrderIds();
        if (is_array($orderId))
        {
            $orderId = array_shift($orderId);
        }
        $order = Mage::getModel('sales/order')->load($orderId);
        $product_vendors = Mage::helper('ppmd_tests/vendors')->getOrderTestVendorProducts($order);

        foreach ($product_vendors as $vendor => $products)
        {
            $observer_model = Mage::getModel($vendor . '/observer');
            $observer_model->submitOrder($order);
        }
    }

    public function getVirtualProducts($products, $by_products_we_mean_items = false)
    {
        $virtual_vendor_products = array();

        foreach ($products as $product)
        {
            $product_to_check = $product;
            if ($by_products_we_mean_items)
            {
                $product_id = $product->getProductId();
                $product_to_check = Mage::getModel('catalog/product')->load($product_id);
            }

            if ($product_to_check->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_VIRTUAL)
            {
                $virtual_vendor_products[] = $product;
            }
        }

        return $virtual_vendor_products;
    }

    public function cartRequiresLabSelection()
    {
        $cart_quote = Mage::helper('checkout/cart')->getQuote();
        $vendor_products = Mage::helper('ppmd_tests/vendors')->getTestVendorProducts($cart_quote->getAllItems());
        $vendors_requiring_lab_selection = $this->getVendorsRequiringLabSelection();

        foreach ($vendor_products as $vendor_code => $vendor_products)
        {
            if (in_array($vendor_code, $vendors_requiring_lab_selection))
            {
                $virtual_products = $this->getVirtualProducts($vendor_products);

                if (count($virtual_products) > 0)
                {
                    return true;
                }
            }
        }

        return false;
    }

    public function getVendorsRequiringLabSelection()
    {
        return array_keys(Mage::getStoreConfig(self::LAB_SELECTION_VENDORS_CONFIG_PATH));
    }

    public function getRootTestCategory()
    {
        $root_test_category_url_key = Mage::getStoreConfig(self::ROOT_TEST_CATEGORY_URL_KEY_CONFIG);

        $root_test_category = Mage::getModel('catalog/category')
                                ->getCollection()
                                ->addAttributeToFilter('url_key', $root_test_category_url_key)
                                ->getFirstItem();

        return $root_test_category;
    }

    public function getAddToCartUrl($product_id)
    {
        return Mage::getBaseUrl().'checkout/cart/add/product/'.$product_id;
    }

    public function getTestsPageUrl()
    {
        if ($path = Mage::getStoreConfig(self::TEST_PAGE_PATH_CONFIG_PATH))
        {
            return Mage::getBaseUrl().$path;
        }
        return Mage::getBaseUrl();
    }

    public function getCurrentCategory()
    {
        $category = Mage::registry('current_category');
        return $category;
    }
}
