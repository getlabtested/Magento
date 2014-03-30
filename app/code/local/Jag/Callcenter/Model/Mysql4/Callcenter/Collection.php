<?php

class Jag_Callcenter_Model_Mysql4_Callcenter_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('callcenter/callcenter');
    }
}