<?php
class Jag_Callcenter_Block_Adminhtml_Medivo extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getMedivo()     
     { 
        if (!$this->hasData('medivo')) {
            $this->setData('medivo', Mage::registry('medivo'));
        }
        return $this->getData('medivo');
        
    }
    
    public function getLabsByZip() {
        
        
        if ($this->getRequest()->getPost('zip_code')) {
        
    	$zipCode = $this->getRequest()->getPost('zip_code');
    	
    	} else {
    	
    	$zipCode = $this->getRequest()->getParam('zip_code');
    	
    	}
    	    	
    	if (Mage::getSingleton('core/session')->getIsNnr()) {
    	    	
    		$medivo = Mage::getModel('medivo/medivo')->getDbLabsByZip($zipCode);
    	
    	} else {
    	
    		$medivo = Mage::getModel('medivo/medivo')->getLabsByZip($zipCode);
    		
    	}

       	return($medivo);
    
    }
    
}