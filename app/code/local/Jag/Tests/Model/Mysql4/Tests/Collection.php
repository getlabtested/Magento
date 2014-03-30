<?php

class Jag_Tests_Model_Mysql4_Tests_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('tests/tests');
    }
}