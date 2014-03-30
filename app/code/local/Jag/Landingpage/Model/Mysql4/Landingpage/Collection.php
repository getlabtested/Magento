<?php

class Jag_Landingpage_Model_Mysql4_Landingpage_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('landingpage/landingpage');
    }
}