<?php

class Jag_Sendmail_Adminhtml_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }
	
	public function sendAction() {
		
		$baseDir = Mage::getBaseDir();

		$orderId = $this->getRequest()->getParam('order_id');
		
		$customerId = $this->getRequest()->getParam('customer_id');
		
		$template = $this->getRequest()->getParam('template');
		
		$admin = $this->getRequest()->getParam('admin');
		
		//echo $orderId; echo $template; exit();
						
		Mage::getModel('sales/order')->load($orderId)->addStatusHistoryComment($admin.' sent '.$template.' email '.date('m/d/Y H:i'))->save();
				                                        
        Mage::getModel('sendmail/sendmail')->sendEmail($orderId,$template);
										
		//echo "Message sent.";
		
		return true;
		
	}
	
	
	public function efaxAction() {
		
		$baseDir = Mage::getBaseDir();

		$orderId = $this->getRequest()->getParam('order_id');
		
		$customerId = $this->getRequest()->getParam('customer_id');
		
		$fax = $this->getRequest()->getParam('efax');
		
		$efaxname = $this->getRequest()->getParam('efaxname');
				
		$admin = $this->getRequest()->getParam('admin');
								
		Mage::getModel('sales/order')->load($orderId)->addStatusHistoryComment($admin.' sent Fax '.date('m/d/Y H:i'))->save();
						                                        
        Mage::getModel('sendmail/sendmail')->sendEfax($orderId,$customerId,$fax,$efaxname);
										
		//echo "Message sent.";
		
		return true;
		
	}
	
	

}