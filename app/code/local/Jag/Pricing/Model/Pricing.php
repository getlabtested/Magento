<?php

class Jag_Pricing_Model_Pricing extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('pricing/pricing');
    }
}