<?php

class Jag_Google_Block_Analytics extends Mage_Core_Block_Template
{
    public function getFirstBlockOfBody()
    {
        return Mage::helper('jag_google')->getFirstBlockOfBody();
    }

    public function getLastBlockOfBody()
    {
        return Mage::helper('jag_google')->getLastBlockOfBody();
    }
}
