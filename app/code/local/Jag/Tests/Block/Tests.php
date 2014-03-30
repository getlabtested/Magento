<?php
class Jag_Tests_Block_Tests extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getTests()     
     { 
        if (!$this->hasData('tests')) {
            $this->setData('tests', Mage::registry('tests'));
        }
        return $this->getData('tests');
        
    }
}