<?php

class Jag_Localepage_Model_Mysql4_Nnr extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the localepage_id refers to the key field in your database table.
        $this->_init('localepage/nnr', 'nnr_id');
    }
}