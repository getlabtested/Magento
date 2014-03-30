<?php

class PPMD_PayPal_Model_Observer
{
    public function setDiscountNotToBeItem($observer)
    {
        $cart = $observer->getData('paypal_cart');
        // PayPal is rejecting the call when discount is sent as an item. It doesn't seem to like when the amount
        // on an item is negative, which is the case when the discount is sent as an item.
        $cart->isDiscountAsItem(false);
    }
}
