<?php

class Jag_Landingpage_Model_Mysql4_Landingpage extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the landingpage_id refers to the key field in your database table.
        $this->_init('landingpage/landingpage', 'landingpage_id');
    }
}