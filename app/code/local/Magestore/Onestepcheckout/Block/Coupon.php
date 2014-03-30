<?php

class Magestore_Onestepcheckout_Block_Coupon extends Mage_Core_Block_Template
{
    public function getAddCouponUrl()
    {
        return $this->getUrl('onestepcheckout/index/addcoupon', array('_secure' => true));
    }
}
