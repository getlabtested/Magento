<?php

class Jag_Google_Model_Observer
{
    const GA_ECOMMERCE_BLOCK_TYPE = 'jag_google/ecommerce';
    const GA_ECOMMERCE_BLOCK_NAME = 'ga_ecommerce';
    const GA_ECOMMERCE_TEMPLATE_FILE = 'jag_google/ecommerce_tracking_js.phtml';

    const WEBSITE_TO_INCLUDE_ECOMMERCE_TRACKING = 'glt';

    public function addEcommerceTrackingGaJs($observer)
    {
        $website = Mage::app()->getWebsite();
        $website_code = $website->getCode();

        if ($website_code == self::WEBSITE_TO_INCLUDE_ECOMMERCE_TRACKING)
        {
            $order_id = $observer->getOrderIds();

            $head_block = Mage::app()->getLayout()->getBlock('head');

            $ga_block = Mage::app()->getLayout()->createBlock(self::GA_ECOMMERCE_BLOCK_TYPE, self::GA_ECOMMERCE_BLOCK_NAME);
            $ga_block->setTemplate(self::GA_ECOMMERCE_TEMPLATE_FILE);
            $ga_block->setOrderIds($order_id);

            $head_block->insert($ga_block);
        }
    }
}
