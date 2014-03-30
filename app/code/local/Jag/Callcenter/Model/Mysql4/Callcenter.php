<?php

class Jag_Callcenter_Model_Mysql4_Callcenter extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the callcenter_id refers to the key field in your database table.
        $this->_init('callcenter/callcenter', 'callcenter_id');
    }
}