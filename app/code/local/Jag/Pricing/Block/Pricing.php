<?php
class Jag_Pricing_Block_Pricing extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getPricing()     
     { 
        if (!$this->hasData('pricing')) {
            $this->setData('pricing', Mage::registry('pricing'));
        }
        return $this->getData('pricing');
        
    }
}