<?php
class Jag_Prescriptions_Block_Prescriptions extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getPrescriptions()     
     { 
        if (!$this->hasData('prescriptions')) {
            $this->setData('prescriptions', Mage::registry('prescriptions'));
        }
        return $this->getData('prescriptions');
        
    }
}