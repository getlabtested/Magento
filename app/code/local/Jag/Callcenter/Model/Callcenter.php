<?php

class Jag_Callcenter_Model_Callcenter extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('callcenter/callcenter');
    }
}