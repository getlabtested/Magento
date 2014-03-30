<?php

class Jag_Prescriptions_Model_Mysql4_Prescriptions extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the prescriptions_id refers to the key field in your database table.
        $this->_init('prescriptions/prescriptions', 'prescriptions_id');
    }
}