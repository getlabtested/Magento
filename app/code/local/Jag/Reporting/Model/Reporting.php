<?php

class Jag_Reporting_Model_Reporting extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('reporting/reporting');
    }
}