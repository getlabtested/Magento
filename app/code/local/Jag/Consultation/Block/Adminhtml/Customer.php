<?php
class Jag_Consultation_Block_Adminhtml_Customer extends Mage_Core_Block_Template
{

    
     public function getCustomerstomer()     
     { 
        if (!$this->hasData('consultation')) {
            $this->setData('consultation', Mage::registry('consultation'));
        }
        return $this->getData('consultation');
        
    }
}