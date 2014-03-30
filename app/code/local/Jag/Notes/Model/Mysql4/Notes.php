<?php

class Jag_Notes_Model_Mysql4_Notes extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the notes_id refers to the key field in your database table.
        $this->_init('notes/notes', 'notes_id');
    }
}