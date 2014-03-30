<?php

class Jag_Landingpage_Model_Landingpage extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('landingpage/landingpage');
    }
}