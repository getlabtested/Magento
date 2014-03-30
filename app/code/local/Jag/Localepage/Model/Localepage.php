<?php

class Jag_Localepage_Model_Localepage extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('localepage/localepage');
    }
}