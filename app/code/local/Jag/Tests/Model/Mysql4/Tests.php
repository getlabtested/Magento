<?php

class Jag_Tests_Model_Mysql4_Tests extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the tests_id refers to the key field in your database table.
        $this->_init('tests/tests', 'tests_id');
    }
}