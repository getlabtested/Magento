<?php 

class Jag_Sendmail_Model_Observer
{
	public function sendOrderEmail(Varien_Event_Observer $observer)
    {
		$orderId = $observer->getEvent()->getOrderIds();
        if (is_array($orderId))
        {
            $orderId = $orderId[0];
        }
                        
        $order = Mage::getModel('sales/order')->load($orderId);
		$customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
		
		$r = rand(10000, 99999);
		$lname = substr($customer->getLastname(), 0,2);
		
		if ($order->getProductLine() != 2) {
			$customer->changePassword($lname.$r);
			$customer->save();
		}
        $new_random_generated_password = $lname.$r;

        Mage::helper('medivo/docconsult')->sendDocConsultEmailIfNecessary($order, $customer);
        Mage::helper('ppmd_tests/vendors')->sendVendorOrderSuccessEmails($order, $customer, $new_random_generated_password);
	}
}
	