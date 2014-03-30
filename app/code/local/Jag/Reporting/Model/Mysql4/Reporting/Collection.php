<?php

class Jag_Reporting_Model_Mysql4_Reporting_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('reporting/reporting');
    }
}