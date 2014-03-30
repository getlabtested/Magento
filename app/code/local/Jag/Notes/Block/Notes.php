<?php
class Jag_Notes_Block_Notes extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getNotes()     
     { 
        if (!$this->hasData('notes')) {
            $this->setData('notes', Mage::registry('notes'));
        }
        return $this->getData('notes');
        
    }
}