<?php

class Jag_Localepage_Model_Mysql4_Dynamic_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('localepage/dynamic');
    }
}