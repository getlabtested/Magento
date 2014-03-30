<?php

class Jag_Notes_Model_Mysql4_Notes_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('notes/notes');
    }
}