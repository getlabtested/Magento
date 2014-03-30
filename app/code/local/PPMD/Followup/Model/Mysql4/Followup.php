<?php

class PPMD_Followup_Model_Mysql4_Followup extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        // Note that the notes_id refers to the key field in your database table.
        $this->_init('ppmd_followup/ppmd_followup', 'followup_id');
    }
}
