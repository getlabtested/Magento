<?php
class PPMD_Testrecommender_Block_results extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getPSC()     
     { 
        if (!$this->hasData('psc')) {
            $this->setData('psc', Mage::registry('psc'));
        }
        return $this->getData('psc');
        
    }
}