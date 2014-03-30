<?php

class Jag_Medivo_Model_Mysql4_Medivo_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('medivo/medivo');
    }
}