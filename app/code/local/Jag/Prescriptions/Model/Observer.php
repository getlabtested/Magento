<?php
class Jag_Prescriptions_Model_Observer
{
    public function __construct()
    {
    	
		
    }
	
	public function createOrder(Varien_Event_Observer $observer) {
		
		Mage::Log('START PRESCRIPTIONS OBSERVER');
		
		$orderId = $observer->getEvent()->getOrderIds();
                
        if (is_array($orderId)) $orderId = $orderId[0];
		
		
		Mage::Log('PRESCRIPTIONS OBSERVER ORDER'.$orderId);
                        
        $order = Mage::getModel('sales/order')->load($orderId);
		
		
		foreach ($order->getItemsCollection() as $item) {
			
			if ($item->getProductId() == 34) {
				
				$script = Mage::getModel('prescriptions/prescriptions');
				$script->setOrderId($order->getId());
				$script->setCustomerId($order->getCustomerId());
				$script->setCustomerName($order->getCustomerName());
				
				$session = Mage::getModel('core/session')->getScriptData();
				
				
		mail('support@getlabtested.net,info@getlabtested.net','NEW PRESCRIPTION ORDER','There is a new prescription order waiting to be filled. Thank you!','From: Prescription Order <no-reply@getlabtested.net>');

				
				Mage::Log('PRESCRIPTIONS OBSERVER PRESCRIPTION');
				
			} 
			
		}
		
		Mage::Log('END PRESCRIPTIONS OBSERVER');
		
		return true;
		
	}
	
	
}