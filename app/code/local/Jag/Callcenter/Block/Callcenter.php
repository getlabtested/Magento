<?php
class Jag_Callcenter_Block_Callcenter extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getCallcenter()     
     { 
        if (!$this->hasData('callcenter')) {
            $this->setData('callcenter', Mage::registry('callcenter'));
        }
        return $this->getData('callcenter');
        
    }
}