<?php
class Jag_Paynearme_Block_Form extends Mage_Payment_Block_Form
{
    protected function _construct()
    {
    	parent::_construct();
        $this->setTemplate('paynearme/form.phtml');
    }

}