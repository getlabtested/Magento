<?php



class Gemini_Affiliates_Model_Affiliates extends Mage_Core_Model_Abstract

{

    public function _construct() {
        parent::_construct();
        $this->_init('affiliates/affiliates');
    }
	
}