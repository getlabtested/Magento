<?php
 
/**
* Our test CC module adapter
*/
class Jag_Paynearme_Model_Paymentmethod extends Mage_Payment_Model_Method_Abstract
{
    const PAYNEARME_HOST   = 'https://paynearme.com/api/';
	const PAYNEARME_METHOD = 'create_order';
    
	const JAG_PAYNEARME_STATUS_ORDER_OPEN = 'open';

	const JAG_PAYNEARME_STATUS_PAYMENT = 'payment';
	const JAG_PAYNEARME_STATUS_DECLINE = 'decline';
   
   /**
    * unique internal payment method identifier
    *
    * @var string [a-z0-9_]
    */
    protected $_code 		  = 'paynearme';
    protected $_formBlockType = 'paynearme/form';
    protected $_infoBlockType = 'paynearme/info';
    
     
    /**
     * Is this payment method a gateway (online auth/charge) ?
     */
    protected $_isGateway               = false;
 
    /**
     * Can authorize online?
     */
    protected $_canAuthorize            = true;
	protected $_isInitializeNeeded      = false;


    /**
     * Can show this payment method as an option on checkout payment page?
     */
    protected $_canUseCheckout          = true;
    
    public function initialize($paymentAction, $stateObject)   {
			
        $state = Mage_Sales_Model_Order::STATE_PENDING_PAYMENT;
        $stateObject->setState($state);
        $stateObject->setStatus('pending_payment');
        $stateObject->setIsNotified(false);
		
    }
	
    public function authorize(Varien_Object $payment, $amount) {
		
	  
		$state = Mage_Sales_Model_Order::STATE_PENDING_PAYMENT;
      	
		
        $orderId = $payment->getOrder()->getId();
	 
		
        $result  	   = $this->doPost($payment,$orderId);
		$order_attribs = $result->order->attributes();
		$pnm_order_identifier = $order_attribs['pnm_order_identifier'];
		
		$slip_attribs = $result->order->slip->attributes();
		
		$pnmpayslip = $slip_attribs['slip_pdf_url'];
		
		
        if(!$result)
            Mage::throwException('Sorry! There was some problem  placing your order. Please try again later.');
         
		 
		$this->setStore($payment->getOrder()->getStoreId());  
		//$order = Mage::getModel('sales/order')->load($orderId);
	
		
		#set the  order id  generated by paynearme
		$payment->getOrder()
				->setPnmOrderIdentifier($order_attribs['pnm_order_identifier'])
				->setState($state)
				->setPnmPaySlip($pnmpayslip)
       			->setStatus('pending_payment')
       			->setIsNotified(false)
				->save();	
		
		
        return $this;
    } 
	
	
	private function getApiUrl() {
        
		if (!Mage::getStoreConfig('payment/paynearme/host')) 
            return self::PAYNEARME_HOST;
        
        return Mage::getStoreConfig('payment/paynearme/host');
    }	
	
	private function getApiMethod() {
        
		if (!Mage::getStoreConfig('payment/paynearme/method')) 
            return self::PAYNEARME_METHOD;
        
        return Mage::getStoreConfig('payment/paynearme/method');
    }
	
	
	public function prepareNvpRequest($payment,$orderId){
		$form_data = Mage::app()->getRequest()->getParams();
		
	
		
		#retrieve the order data
		$_orderData	    	  = $payment->getOrder()->getData();
		$_billing 			  = $payment->getOrder()->getBillingAddress();
		
		Mage::Log('PNM 118');
		//Mage::Log($_orderData);
		
		#customer info
        $customer_name        = $_orderData['firstname'];
		$customer_is_guest 	  = $_orderData['customer_is_guest'];		
		$total_amount 		  = round($_orderData['grand_total'], 2);
		
	
		//$incId = $payment->getOrder()->getIncrementId();
        
		#api credentials
        $site_identifier 	  = Mage::getStoreConfig('payment/paynearme/site_identifier');
        $site_key 			  = Mage::getStoreConfig('payment/paynearme/site_key');
        $api_version 		  = Mage::getStoreConfig('payment/paynearme/version');
        $paynearme_host 	  = Mage::getStoreConfig('payment/paynearme/host');
        
		$timeparts = explode(" ",microtime());
		
		$num = rand(100000000, 999999999);
		
		Mage::Log('start prepare pnm');
		
		Mage::Log($num);
				
        $customer_id		  = $customer_is_guest?"Guest":$_orderData['customer_id'];

        $nvp_values			  = array( "order_amount"  				=> $total_amount,                    
									   "order_currency"				=> "USD",
                    				   "order_type"					=> "exact",
									   "site_order_identifier"		=> $num,
                   					   //"site_customer_email"		=> $_orderData['customer_email'],
                  					   //"site_customer_name" 		=> $_billing->getName(),                                                           
                  					   "site_customer_identifier"	=> $customer_id,
                 					   "site_customer_postal_code" 	=> $_orderData['lab_zip'],
									  // "site_customer_phone"		=> $_billing->getTelephone(),
									   //"site_customer_street"		=> $_billing->getStreet(1),
                					   //"site_customer_city"			=> $_billing->getCity(),
                					   "site_customer_state"		=> $_orderData['order_state'],
                					   "timestamp"					=> $timeparts[1],
                  					   "version"					=> $api_version,
                   					   "site_identifier"			=> $site_identifier,
									   "return_html_slip"			=> "true"
           							 );
           							 
		Mage::Log('WALUES');
		//Mag::Log($nvp_values);
		
		if($form_data['pay_with']=='card' &&  Mage::getStoreConfig('payment/paynearme/site_enable_paywithcard'))
		   $nvp_values['site_customer_pnmc'] = $form_data['customer_pnmc'];
			
		ksort($nvp_values);
		
		$sign	 = null;
        
		foreach ($nvp_values as $key => $value){
           $sign.= $key.$value; 
		}
		
		$sign .= $site_key;
		
        //$nvp_values['signature'] =  md5($sign);
        
		$fields = "";
		
		foreach( $nvp_values as $key => $value ) {
			$fields_array[]= "$key=" . urlencode( $value );
		}
		
		$fields = @implode('&',$fields_array);
		
		//echo "timestamp=".$timeparts[1]."&".$fields."&signature=".md5($sign); exit();
		
		Mage::Log($fields."&signature=".md5($sign));
		
		return $fields."&signature=".md5($sign);
		
	}

	
    public function doPost($payment,$orderId) {
		
			$nvp_request = $this->prepareNvpRequest($payment,$orderId);
			
			$api_url = $this->getApiUrl().$this->getApiMethod();
		
			
		
			$ch 	 = curl_init();
			curl_setopt($ch, CURLOPT_URL,$api_url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HEADER, false); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $nvp_request); 
			
			$resp = curl_exec($ch);
			curl_close ($ch);
			
			
			if($resp === false) {
				 $message = "Customer ID: " . $custID . " Curl response to " . $paynearme_host . " failed. Curl error: " . curl_error($ch);
				 Mage::Log($message);
				 //exit();
			}
			
			if(empty($resp)) {
				 $message = "Customer ID: " . $custID . " Curl response to " . $paynearme_host . " failed. No content. Curl error: " . curl_error($ch);
				 Mage::Log($message);
				 //exit();
			}
				
		$xml    = simplexml_load_string($resp);
		
		Mage::Log($xml);
		
		$status = $xml->attributes();
		
		//header("Content-type:text/xml");
		//print_r($resp);
		//exit;
		
		
		if($status == "ok"){
			return $xml;
		} else if($status == "error"){
			
			foreach($xml->errors->error as $error){
				 	$desc 	   = $error->attributes();
					$error_msg.= $desc['description']."\r\n";  
			} 
				
			Mage::Log($error_msg);
			exit();	
		} else {
			return false;
		}
		
	}
	
	public function confirmPayment(){
		$result = (object)Mage::app()->getRequest()->getParams();
	    $order = Mage::getResourceModel('sales/order_collection')
        			  ->addAttributeToFilter('pnm_order_identifier', $result->pnm_order_identifier)
					  ->getData();
	
		$myOrder = Mage::getModel('sales/order')->load($order[0]['entity_id']);
	
		$orderId     = $myOrder->getId();
		$incrementId = $myOrder->getIncrementId();
		
		if(!$orderId)
			Mage::throwException(Mage::helper('core')->__('Cannot create an invoice.'));
			
		switch($result->status){
			
			#if the status is payment(success)
			case self::JAG_PAYNEARME_STATUS_PAYMENT:
					try {					
							
							if(!$myOrder->canInvoice())
								Mage::throwException(Mage::helper('core')->__('Cannot create an invoice.'));
							
							
							$invoice = Mage::getModel('sales/service_order', $myOrder)
										   ->prepareInvoice();
							
							if (!$invoice->getTotalQty()) 
									Mage::throwException(Mage::helper('core')->__('Cannot create an invoice without products.'));
							
							 $invoice->register()->pay();
						
							
							Mage::getModel('core/resource_transaction')
								->addObject($invoice)
								->addObject($invoice->getOrder())
								->save();
							$invoice->save();
							//$invoice->sendEmail(true, '');
		
							$myOrder->addStatusToHistory(Mage_Sales_Model_Order::STATE_PROCESSING,'Callback was successfully executed by PNM');
							try {
							
	$order->getPayment()->addTransaction(Mage_Sales_Model_Order_Payment_Transaction::TYPE_CAPTURE,null,false,'PNM Transaction PAID');
								
								mail('ljrweb@gmail.com','success pnm add transaction',$order->getId());
							
							} catch(Exception $e) {
								
								mail('ljrweb@gmail.com','failed pnm add transaction',$order->getId());
							
							}
							
							/*
									->sendNewOrderEmail()
									->setIsCustomerNotified(true);*/
							
							// $myOrder->sendNewOrderEmail()
									// ->setIsCustomerNotified(true);

					} catch (Mage_Core_Exception $e) {
						Mage::throwException(Mage::helper('core')->__('Cannot create an invoice.'));
					}
			break;
			
			#if the status is decline
			case self::JAG_PAYNEARME_STATUS_DECLINE:
				$myOrder->cancel()
						->addStatusToHistory(Mage_Sales_Model_Order::STATE_CANCELED, 'Customer cancelled payment');

				break;
				
			#if the status is not set	
			default:
				$myOrder->cancel()
						->addStatusToHistory(Mage_Sales_Model_Order::STATE_CANCELED, 'PNM rejected the payment');

		}
				
		$myOrder->save();
		
		return true;	
		
	}
	
	 public function capture(Varien_Object $payment, $amount) {
	        $payment->setLastTransId($this->getTransactionId());
	
	        return $this;
	 }
	
 	public function cancel(Varien_Object $payment) {
	        $payment->setStatus(self::STATE_CANCELED);
	
	        return $this;
	}
}
?>