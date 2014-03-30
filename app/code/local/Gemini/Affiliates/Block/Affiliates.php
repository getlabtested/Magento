<?php

class Gemini_Affiliates_Block_Affiliates extends Mage_Core_Block_Template

{

    protected $_last_order = null;

	public function _prepareLayout() {
		return parent::_prepareLayout();
    }


     public function getAffiliates() { 
        if (!$this->hasData('affiliates')) {
            $this->setData('affiliates', Mage::registry('affiliates'));
        }
        return $this->getData('affiliates');
    }

    public function getPapAccountId()
    {
        $store = Mage::app()->getStore();
        $store_code = $store->getCode();
        $pap_credentials = Mage::helper('ppmd_credentials/pap')->getCredentialsByStoreCode($store_code);
        return $pap_credentials['account_id'];
    }

    public function getLastOrder()
    {
        return Mage::helper('onestepcheckout')->getLastOrder();
    }

    public function getTotalCost()
    {
        $order = $this->getLastOrder();
        if (!is_object($order))
        {
            return '';
        }

        return $order->getGrandTotal();
    }

    public function getProductId()
    {
        $order = $this->getLastOrder();
        if (!is_object($order))
        {
            return '';
        }

        $order_skus = array();
        foreach ($order->getAllItems() as $item)
        {
            $order_skus[] = $item->getSku();
        }

        return implode(',', $order_skus);
    }

    public function getOrderId()
    {
        $order = $this->getLastOrder();
        if (!is_object($order))
        {
            return '';
        }

        return $order->getIncrementId();
    }
}