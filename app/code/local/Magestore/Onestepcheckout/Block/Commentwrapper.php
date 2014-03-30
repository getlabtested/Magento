<?php

class Magestore_Onestepcheckout_Block_CommentWrapper extends Magestore_Onestepcheckout_Block_Onestepcheckout
{
    public function isCustomerLoggedIn()
    {
        return Mage::getSingleton('customer/session')->isLoggedIn();
    }
}
