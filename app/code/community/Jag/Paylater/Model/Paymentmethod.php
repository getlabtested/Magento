<?php
 
/**
* Our test CC module adapter
*/
class Jag_Paylater_Model_Paymentmethod extends Mage_Payment_Model_Method_Abstract
{
    
   
   /**
    * unique internal payment method identifier
    *
    * @var string [a-z0-9_]
    */
    protected $_code 		  = 'paylater';
    protected $_formBlockType = 'paylater/form';
    protected $_infoBlockType = 'paylater/info';
    
     
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
	 		
		         
		 
		$this->setStore($payment->getOrder()->getStoreId());  
		//$order = Mage::getModel('sales/order')->load($orderId);
	
		
		#set the  order id  generated by paynearme
		$payment->getOrder()
				->setState($state)
       			->setStatus('pending_payment')
       			->setIsNotified(false)
				->save();	
		
		
        return $this;
    } 
	

	
    
}
?>