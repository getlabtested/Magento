<?php

class Jag_Google_Block_Tracking extends Mage_Core_Block_Template
{
    public function getConversionTrackingCode()
    {
        return Mage::helper('jag_google')->getAdwordsConversionTrackingCode();
    }
}
