<?php

class Jag_Admindashboard_Adminhtml_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {

		$orderId = $this->getRequest()->getParam('order_id');
		
		$status = $this->getRequest()->getParam('status');
		
		$fstatus = $this->getRequest()->getParam('followup_status');
			
		$ostatus = $this->getRequest()->getParam('order_status');
		
		$admin = $this->getRequest()->getParam('admin');
		
				
		$order = Mage::getModel('sales/order')->load($orderId);
				
			
				
			if ($order->getPpmdStatus() != $status) {
				
				$order->setPpmdStatus($status);
				
				
				 switch ($status) {
			                    
									case 0:
										
										$o = "Pending";
										
									break;
									
									case 1: 
			                    	
			                    		$o = "Interpretation";
									
									break;
									
									case 2: 
			                    	
			                    		$o = "Complete";
									
									break;
									
									case 3: 
			                    	
			                    		$o = "Customer Recieved";
									
									break;

			                    	
			                    }
				
				
				$order->addStatusHistoryComment($admin.' set result status to '.$o.' '.date('m/d/Y H:i'));
				
			}
			
			if ($order->getFollowUp() != $fstatus) {
			
				$order->setFollowUp($fstatus);
				
				 switch ($fstatus) {
			                    
									case 0:
										
										$s =  "NONE";
										
									break;
									
									case 1: 
			                    	
			                    		$s =  "Mail Homekit";
									
									break;
									
									case 2: 
			                    	
			                    		$s =  "Fax Req";
									
									break;
									
									case 7: 
			                    	
			                    		$s =  "Upload Req";
									
									break;
									
									case 3: 
			                    	
			                    		$s =  "Send Invoice";
									
									break;
									
									case 4: 
			                    	
			                    		$s =  "Doc Consultation";
									
									break;
									
									case 5: 
			                    	
			                    		$s =  "Needs Call";
									
									break;
									
									case 6: 
			                    	
			                    		$s =  "Other";
									
									break;
									
									case 8: 
			                    	
			                    		$s = "Call Lab";
									
									break;

			                    }
			
				$order->addStatusHistoryComment($admin.' set follow status to '.$s.' '.date('m/d/Y H:i'));
			
			}
			
			if ($ostatus != "")  {
			
				if ($ostatus == 'complete' && $order->getStatus() != 'complete') {
										
															
					try {	
					
					
					$invoice = $order->prepareInvoice()
            ->setTransactionId($order->getIncrementId())
            ->addComment('PL Transaction PAID')
            ->register()
            ->pay();
            
            $order->addStatusHistoryComment($admin.' set payment status to '.$ostatus.' '.date('m/d/Y H:i'));

        $transactionSave = Mage::getModel('core/resource_transaction')
            ->addObject($invoice)
            ->addObject($invoice->getOrder());

        $transactionSave->save();
					
					try {
							
	$order->getPayment()
		->addTransaction(Mage_Sales_Model_Order_Payment_Transaction::TYPE_CAPTURE,null,false,'PL Transaction PAID');
								
							
} catch(Exception $e) {
								
							
}
					
					/*
$invoice = Mage::getModel('sales/service_order', $order)
						->prepareInvoice()
						->register()
						->pay();
						
					Mage::getModel('core/resource_transaction')
						->addObject($invoice)
						->addObject($invoice->getOrder())
						->save();
*/
						
						
					
					$invoice->save();
					
					
/*
					try {
							
	$order->getPayment()
		->addTransaction(Mage_Sales_Model_Order_Payment_Transaction::TYPE_CAPTURE,null,false,'PL Transaction PAID');
								
	mail('ljrweb@gmail.com','success PL add transaction',$order->getId());
							
} catch(Exception $e) {
								
	mail('ljrweb@gmail.com','failed PL add transaction',$order->getId());
							
}
	
*/				
					
					
					} catch (Exception $e) {
						
						Mage::Log(print_r($e->getMessage(),true));
						exit();
						
					}
					
				}
				
			}
		

		$order->save();
		
		return;
		
    }
	

	
}