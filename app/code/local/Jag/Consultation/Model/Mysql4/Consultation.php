<?php

class Jag_Consultation_Model_Mysql4_Consultation extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the consultation_id refers to the key field in your database table.
        $this->_init('consultation/consultation', 'consultation_id');
    }
}