<?php
class Jag_Medivo_Block_Medivo extends Mage_Core_Block_Template
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
    
    public function getLabsByZip()
    {
        if ($this->getPostedZipCode()) {
            $zipCode = $this->getRequest()->getPost('zip_code');
        } else {
            $zipCode = $this->getRequest()->getParam('zip_code');
        }

        if (Mage::getSingleton('core/session')->getIsNnr()) {
            $labs_array = Mage::getModel('medivo/medivo')->getDbLabsByZip($zipCode);
        } else {
            $labs_array = Mage::getModel('medivo/medivo')->getLabsByZip($zipCode);
        }

        return $labs_array;
    }

    public function isNotAllowedLabLookupState()
    {
        $zipcode = $this->getPostedZipCode();
        if (empty($zipcode))
        {
            return false;
        }
        $state = Mage::helper('medivo')->getStateFromZipCode($zipcode);
        $is_state_not_allowed = Mage::helper('medivo/labs')->isNotAllowedLabLookupState($state);
        return $is_state_not_allowed;
    }

    public function locationsWereFound($locations)
    {
        return (!is_array($locations) || !count($locations)) && !is_object($locations);
    }

    public function getPostedZipCode()
    {
        return $this->getRequest()->getPost('zip_code');
    }

    public function getSelectLabAction()
    {
        return Mage::helper('medivo')->getSelectLabUrl();
    }

    public function getAtHomeTestsPageUrl()
    {
        return Mage::helper('medivo')->getAtHomeTestsPageUrl();
    }
}