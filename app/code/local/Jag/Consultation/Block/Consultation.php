<?php
class Jag_Consultation_Block_Consultation extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getConsultation()     
     { 
        if (!$this->hasData('consultation')) {
            $this->setData('consultation', Mage::registry('consultation'));
        }
        return $this->getData('consultation');
        
    }
}