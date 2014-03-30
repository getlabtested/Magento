<?php

class PPMD_Tests_Model_Observer
{
    public function orderSubmit($observer)
    {
        $orderId = $observer->getEvent()->getOrderIds();
        if (is_array($orderId)) $orderId = $orderId[0];
        $order = Mage::getModel('sales/order')->load($orderId);

        $vendor_products = Mage::helper('ppmd_tests/vendors')->getProductVendors($order->getItemsCollection());
        foreach ($vendor_products as $vendor)
        {
            $vendor_observer = Mage::getModel($vendor . "/observer");
            $vendor_observer->submitOrder($order);
        }

        Mage::getModel('sendmail/observer')->sendOrderEmail($observer);
    }
}
