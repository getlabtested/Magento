<?php

class Jag_Notes_Model_Notes extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('notes/notes');
    }
}