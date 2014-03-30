<?php

class Magestore_Upsell_Block_Upsell extends Mage_Core_Block_Template
{
    public function getUpsellPostActionUrl()
    {
        return $this->getUrl('customroute/index/checkout', array('_secure' => true));
    }

    public function getNoThanksAction()
    {
        return $this->getUrl('customroute/index/checkout', array('_secure' => true));
    }

    public function getOnlyIndivdualUpsellProducts()
    {
        return Mage::helper('upsell')->getOnlyIndivdualUpsellProducts();
    }

    public function getWellnessPackageProduct()
    {
        return Mage::helper('upsell')->getWellnessPackageUpsell();
    }

    public function getUpsellProductsByCart()
    {
        return Mage::helper('upsell')->getUpsellProductsByCart();
    }
}
