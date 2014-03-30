<?php

class Jag_Reporting_Model_Mysql4_Reporting extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the reporting_id refers to the key field in your database table.
        $this->_init('reporting/reporting', 'reporting_id');
    }
}