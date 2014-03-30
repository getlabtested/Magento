<?php

class Jag_Prescriptions_Model_Mysql4_Prescriptions_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('prescriptions/prescriptions');
    }
}