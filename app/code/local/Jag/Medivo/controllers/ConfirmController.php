<?php

class Jag_Medivo_ConfirmController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    		
		$param = $this->getRequest()->getParam('id');
		
		$id = $param/1488;
			
		$order = Mage::getModel('sales/order')->load($id);
		
		$order->setPpmdActivate(1);
		
		$order->save();
			
		Mage::dispatchEvent('ppmd_order_activate', $order);
		
		$r = rand(10000, 99999);
			
		$customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
		
		$lname = substr($customer->getLastname(), 0,2);
		
		$customer->changePassword($lname.$r);
		
		//@todo send customer account email
		
	}
	
}
    	