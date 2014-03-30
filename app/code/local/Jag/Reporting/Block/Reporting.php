<?php
class Jag_Reporting_Block_Reporting extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getReporting()     
     { 
        if (!$this->hasData('reporting')) {
            $this->setData('reporting', Mage::registry('reporting'));
        }
        return $this->getData('reporting');
        
    }
}