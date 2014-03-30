<?php

class Jag_Medivo_Model_Mysql4_Medivo extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the medivo_id refers to the key field in your database table.
        $this->_init('medivo/medivo', 'medivo_id');
    }
}