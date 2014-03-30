<?php

class Jag_Google_Helper_Data
{
    const GOOGLE_ANALYTICS_ACCOUNT_ID_CONFIG = 'google/analytics/account';

    const GOOGLE_MAP_API_KEY_CONFIG_PATH = 'google/googlemaps/api_key';
    const GOOGLE_MAP_WIDTH_CONFIG_PATH = 'google/googlemaps/width';
    const GOOGLE_MAP_HEIGHT_CONFIG_PATH = 'google/googlemaps/height';
    const GOOGLE_FIRST_BLOCK_OF_BODY = 'google/analytics/first_block_of_body';
    const GOOGLE_LAST_BLOCK_OF_BODY = 'google/analytics/second_block_of_body';
    const GOOGLE_CHECKOUT_SUCCESS_PAGE_BLOCK = 'google/analytics/checkout_success_page_block';

    const LAST_ORDER_VALUE_SUBSTITUTION_STRING = '###ORDER_TOTAL###';

    public function getGAAccountId()
    {
        return Mage::getStoreConfig(self::GOOGLE_ANALYTICS_ACCOUNT_ID_CONFIG);
    }

    public function getMapWidth()
    {
        return Mage::getStoreConfig(self::GOOGLE_MAP_WIDTH_CONFIG_PATH);
    }

    public function getMapHeight()
    {
        return Mage::getStoreConfig(self::GOOGLE_MAP_HEIGHT_CONFIG_PATH);
    }

    public function getMapApiKey()
    {
        return Mage::getStoreConfig(self::GOOGLE_MAP_API_KEY_CONFIG_PATH);
    }

    public function getFirstBlockOfBody()
    {
        return Mage::getStoreConfig(self::GOOGLE_FIRST_BLOCK_OF_BODY);
    }

    public function getLastBlockOfBody()
    {
        return Mage::getStoreConfig(self::GOOGLE_LAST_BLOCK_OF_BODY);
    }

    public function getAdwordsConversionTrackingCode()
    {
        $conversion_tracking_code = Mage::getStoreConfig(self::GOOGLE_CHECKOUT_SUCCESS_PAGE_BLOCK);

        if (strpos($conversion_tracking_code, self::LAST_ORDER_VALUE_SUBSTITUTION_STRING) !== FALSE)
        {
            $last_order_total = Mage::helper('onestepcheckout')->getLastOrderTotal();
            $conversion_tracking_code = str_replace(self::LAST_ORDER_VALUE_SUBSTITUTION_STRING, $last_order_total, $conversion_tracking_code);
        }

        return $conversion_tracking_code;
    }
}
