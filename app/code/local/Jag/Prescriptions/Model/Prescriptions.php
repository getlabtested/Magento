<?php

class Jag_Prescriptions_Model_Prescriptions extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('prescriptions/prescriptions');
    }
}