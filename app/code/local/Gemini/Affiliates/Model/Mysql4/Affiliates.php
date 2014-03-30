<?php



class Gemini_Affiliates_Model_Mysql4_Affiliates extends Mage_Core_Model_Mysql4_Abstract

{

    public function _construct()

    {    
        $this->_init('affiliates/affiliates', 'id');

    }

}