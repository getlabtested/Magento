<?php

class Magestore_Onestepcheckout_Block_Errors extends Mage_Core_Block_Template
{
    public function shouldShowErrors()
    {
        return (
            is_array(Mage::getSingleton('checkout/session')->getMessages()->getErrors())
            &&
            (count(Mage::getSingleton('checkout/session')->getMessages()->getErrors()) > 0)
        );
    }

    public function getCheckoutErrorsMessage()
    {
        Mage::app()->getLayout()->getMessagesBlock()->setMessages(
            Mage::getSingleton('checkout/session')->getMessages(true)
        );
        return $this->getMessagesBlock()->getGroupedHtml();
    }
}