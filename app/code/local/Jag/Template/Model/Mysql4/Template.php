<?php

class Jag_Template_Model_Mysql4_Template extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the template_id refers to the key field in your database table.
        $this->_init('template/template', 'template_id');
    }
}