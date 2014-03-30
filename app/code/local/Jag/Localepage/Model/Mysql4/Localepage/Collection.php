<?php

class Jag_Localepage_Model_Mysql4_Localepage_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('localepage/localepage');
    }
}