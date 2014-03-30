<?php

class Jag_Tests_Model_Tests extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('tests/tests');
    }
}