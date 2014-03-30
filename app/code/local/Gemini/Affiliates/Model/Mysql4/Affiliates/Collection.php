<?php



class Gemini_Affiliates_Model_Mysql4_Affiliates_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract

{

    public function _construct()

    {

        parent::_construct();

        $this->_init('affiliates/affiliates');

    }

}