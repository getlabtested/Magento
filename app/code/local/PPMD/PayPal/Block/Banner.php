<?php

class PPMD_PayPal_Block_Banner extends Mage_Core_Block_Template
{
    const PAYPAL_BANNER_URL_CONFIG_PATH = 'ppmd_paypal/banner_url';
    const PAYPAL_BANNER_HEADER_TYPE_PATH = 'ppmd_paypal/header_type';
    const PAYPAL_BANNER_SIDEBAR_TYPE_PATH = 'ppmd_paypal/sidebar_type';
    const PAYPAL_BANNER_PUBID_CONFIG_PATH = 'ppmd_paypal/banner_pubid';

    public function getPaypalBannerUrl()
    {
        return Mage::getStoreConfig(self::PAYPAL_BANNER_URL_CONFIG_PATH);
    }

    public function getPaypalHeaderBannerType()
    {
        return Mage::getStoreConfig(self::PAYPAL_BANNER_HEADER_TYPE_PATH);
    }

    public function getPaypalSidebarBannerType()
    {
        return Mage::getStoreConfig(self::PAYPAL_BANNER_SIDEBAR_TYPE_PATH);
    }

    public function getPaypalBannerPubId()
    {
        return Mage::getStoreConfig(self::PAYPAL_BANNER_PUBID_CONFIG_PATH);
    }
}
