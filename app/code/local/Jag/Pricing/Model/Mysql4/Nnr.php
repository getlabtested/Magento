<?php

class Jag_Pricing_Model_Mysql4_Nnr extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the pricing_id refers to the key field in your database table.
        $this->_init('pricing/nnr', 'pricing_nnr_id');
    }
}