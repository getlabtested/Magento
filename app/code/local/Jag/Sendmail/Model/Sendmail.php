<?php 

class Jag_Sendmail_Model_Sendmail {

	public function sendCustomerEmail(Mage_Customer_Model_Customer $customer) {
		
		$r = rand(10000, 99999);
					
		$lname = substr($customer->getLastname(), 0,2);
		
		$customer->changePassword($lname.$r);
		
	}
	
	public function sendEmail($orderId,$templateId) {
		
		$baseDir = Mage::getBaseDir();
		
		$order = Mage::getModel('sales/order')->load($orderId);
				
		$customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
		
		$template = Mage::getModel('core/email_template');
				
		
		switch ($templateId) {
			
			case "ppmd_test_results_available_paid":
											
				// PAID, TESTS RESULTS AVAILABLE
									
					$template->getMail()->setSubject('PPMD Test Results Available');
					
					$template->sendTransactional('ppmd_test_results_available_paid','general',$customer->getEmail(),$customer->getFirstname().' '.$customer->getLastname(),array('order'=>$order,'customer'=>$customer));
											
			break;
		
			case "ppmd_order_confirmation_lab":
			
				// PAID NOW, LAB TEST, 47 STATES
				
				if (!file_exists($baseDir.'/req/'.$order->getIncrementId().'.pdf')) {
	    		
				Mage::getModel('medivo/medivo')->pullReq($order->getId());
				
	    		} 
												
				$attachment = $template->getMail()->createAttachment(file_get_contents($baseDir.'/req/'.$order->getIncrementId().'.pdf'));
	    		$attachment->filename = 'RequisitionFile.pdf';
				
				$r = rand(10000, 99999);
					
				$lname = substr($customer->getLastname(), 0,2);
				
				$customer->changePassword($lname.$r);
		
				$customer->save();
								
				$template->getMail()->setSubject('PPMD Order Confirmation');

                $email_template_code = Mage::helper('sendmail')->getEmailTemplateByStoreId('order_confirmation', $order->getStoreId());

				$template->sendTransactional($email_template_code,'general',$customer->getEmail(),$customer->getFirstname().' '.$customer->getLastname(),array('order'=>$order,'customer'=>$customer,'pass'=>$lname.$r));
										
			break;
			
			case "ppmd_order_confirmation_home":
			
				// PAID NOW, HOME TEST, 47 STATES

				$r = rand(10000, 99999);
					
				$lname = substr($customer->getLastname(), 0,2);
				
				$customer->changePassword($lname.$r);
		
				$customer->save();
								
				$template->getMail()->setSubject('PPMD Order Confirmation');
				
				$template->sendTransactional('ppmd_order_confirmation_home','general',$customer->getEmail(),$customer->getFirstname().' '.$customer->getLastname(),array('order'=>$order,'customer'=>$customer,'pass'=>$lname.$r));
										
			break;
			
			case "ppmd_prescription_available":
											
				if ($order->getProductLine() == 2) {
												
				$template->getMail()->setSubject('PPMD Prescription Available');
				
				$template->sendTransactional('ppmd_prescription_available','general',$customer->getEmail(),$customer->getFirstname().' '.$customer->getLastname(),array('customer'=>$customer));
						
				}
			
			break;
			
			case "ppmd_prescription_conf":
											
				if ($order->getProductLine() == 2) {
												
				$template->getMail()->setSubject('PPMD Prescription Available');
				
				$template->sendTransactional('ppmd_prescription_available','general',$customer->getEmail(),$customer->getFirstname().' '.$customer->getLastname(),array('customer'=>$customer));
						
				}
			
			break;
			
			case "ppmd_order_activation_pwc":
			
				// PAID CASH, LAB TEST, 47 STATES , NOT ACTIVATED
		
				if ($order->getPpmdActivate() == 0 && $order->getOrderType() == 1) {
		    		
		    		$inc = $order->getId()*1488;
									
					$template->getMail()->setSubject('PPMD Order Activation');
					
					$template->sendTransactional('ppmd_order_activation_pwc','general',$customer->getEmail(),$customer->getFirstname().' '.$customer->getLastname(),array('order'=>$order,'customer'=>$customer,'inc'=>$inc));
							
				}
			
			break;
			
			case "ppmd_order_confirmation_pwc_active":
			
				// PAID CASH, LAB TEST, 47 STATES , ACTIVATED
				
				if (!file_exists($baseDir.'/req/'.$order->getIncrementId().'.pdf')) {
	    		
					Mage::getModel('medivo/medivo')->pullReq($order->getId());
				
	    		} 
		
				$attachment = $template->getMail()->createAttachment(file_get_contents($baseDir.'/req/'.$order->getIncrementId().'.pdf'));
	    		$attachment->filename = 'RequisitionFile.pdf';
				
				if ($order->getLabType() == 129) {
			
					$attachmentTwo= $template->getMail()->createAttachment(file_get_contents($baseDir.'/ins/LabCorp-Instructions.pdf'));
	    			$attachmentTwo->filename = 'LabCorp-Instructions.pdf';	
				
				} else {
					
					$attachmentTwo= $template->getMail()->createAttachment(file_get_contents($baseDir.'/ins/QuestLab-Instructions.pdf'));
	    			$attachmentTwo->filename = 'QuestLab-Instructions.pdf';	
					
				}
				
				$r = rand(10000, 99999);
					
				$lname = substr($customer->getLastname(), 0,2);
				
				$customer->changePassword($lname.$r);
		
				$customer->save();
												
				$template->getMail()->setSubject('PPMD Order Confirmation');
				
				$template->sendTransactional('ppmd_order_confirmation_pwc_active','general',$customer->getEmail(),$customer->getFirstname().' '.$customer->getLastname(),array('order'=>$order,'customer'=>$customer,'pass'=>$lname.$r,'payslip'=>$order->getPnmPaySlip()));
			
			break;
						
			
			case "ppmd_pwc_order_activation_reminder_1":
			
				// PAID CASH, LAB TEST, 47 STATES , NOT ACTIVATED , 24 HOURS
		
				if ($order->getPpmdActivate() == 0 && $order->getOrderType() == 1) {
		    		
		    		$inc = $order->getId()*1488;
									
					$template->getMail()->setSubject('PPMD Order Activation Reminder');
					
					$template->sendTransactional('ppmd_pwc_order_activation_reminder_1','general',$customer->getEmail(),$customer->getFirstname().' '.$customer->getLastname(),array('order'=>$order,'customer'=>$customer,'inc'=>$inc));
							
				}
			
			break;
			
			case "ppmd_pwc_reminder_8":
			
				// PAID CASH, LAB TEST, 47 STATES , NOT PAID , 8 DAYS
				
				if (!file_exists($baseDir.'/req/'.$order->getIncrementId().'.pdf')) {
	    		
					Mage::getModel('medivo/medivo')->pullReq($order->getId());
				
	    		} 
		
				$attachment = $template->getMail()->createAttachment(file_get_contents($baseDir.'/req/'.$order->getIncrementId().'.pdf'));
	    		$attachment->filename = 'RequisitionFile.pdf';
				
				if ($order->getLabType() == 129) {
			
					$attachmentTwo= $template->getMail()->createAttachment(file_get_contents($baseDir.'/ins/LabCorp-Instructions.pdf'));
	    			$attachmentTwo->filename = 'LabCorp-Instructions.pdf';	
				
				} else {
					
					$attachmentTwo= $template->getMail()->createAttachment(file_get_contents($baseDir.'/ins/QuestLab-Instructions.pdf'));
	    			$attachmentTwo->filename = 'QuestLab-Instructions.pdf';	
					
				}
				
				$r = rand(10000, 99999);
				
				if ($customer->getLastname()) {
					
				$lname = substr($customer->getLastname(), 0,2);
								
				$customer->changePassword($lname.$r);
		
				$customer->save();
				
				}
												
				$template->getMail()->setSubject('PPMD Test Results Reminder');
				
				$template->sendTransactional('ppmd_pwc_reminder_8','general',$customer->getEmail(),$customer->getFirstname().' '.$customer->getLastname(),array('order'=>$order,'customer'=>$customer,'pass'=>$lname.$r,'payslip'=>$order->getPnmPaySlip()));
			
			break;
		
		}
		
	}
	
	
	
	public function sendEfax($orderId,$templateId,$fax,$name) {
		
		$baseDir = Mage::getBaseDir();
		
		$order = Mage::getModel('sales/order')->load($orderId);
				
		$customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
		
		$e = $fax."@myfax.com";
				
		$template = Mage::getModel('core/email_template');
		
							
			if (!file_exists($baseDir.'/req/'.$order->getIncrementId().'.pdf')) {
	    		
				Mage::getModel('medivo/medivo')->pullReq($order->getId());
				
	    	} 			
	    												
				$attachment = $template->getMail()->createAttachment(file_get_contents($baseDir.'/req/'.$order->getIncrementId().'.pdf'));
	    		$attachment->filename = 'RequisitionFile.pdf';
	    		
	    			    		
	    		if ($order->getLabType() == 129) {
			
					$attachmentTwo= $template->getMail()->createAttachment(file_get_contents($baseDir.'/ins/LabCorp-Instructions.pdf'));
	    			$attachmentTwo->filename = 'LabCorp-Instructions.pdf';	
				
				} else {
					
					$attachmentTwo= $template->getMail()->createAttachment(file_get_contents($baseDir.'/ins/QuestLab-Instructions.pdf'));
	    			$attachmentTwo->filename = 'QuestLab-Instructions.pdf';	
					
				}
												
				$template->getMail()->setSubject('Patient Service Center');
				
				
				try {
				
				$template->sendTransactional('efax','custom1',$e,$name,array('name'=>$name));
				
				} catch (Exception $e) {
				
					print_r($e->getMessage()); exit();
				
				}
										
		
	}
	
	

}