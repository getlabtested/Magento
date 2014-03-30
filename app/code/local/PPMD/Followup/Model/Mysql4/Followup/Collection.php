<?php

class PPMD_Followup_Model_Mysql4_Followup_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('ppmd_followup/followup');
    }
}
