<?php

class Jag_Consultation_Model_Mysql4_Consultation_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('consultation/consultation');
    }
}