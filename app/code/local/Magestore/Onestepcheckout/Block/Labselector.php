<?php

class Magestore_Onestepcheckout_Block_Labselector extends Mage_Core_Block_Template
{
    public function isCustomerLoggedIn()
    {
        return Mage::getSingleton('customer/session')->isLoggedIn();
    }

    public function getSessionLabData()
    {
        return Mage::helper('medivo/labs')->getSessionLabData();
    }
}
