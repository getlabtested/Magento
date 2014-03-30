<?php

class Jag_Callcenter_Adminhtml_OrderController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout()->renderLayout();
    }
    
    public function postAction()
    {
        $post = $this->getRequest()->getPost();
		
		try {
            if (empty($post)) {
                Mage::throwException($this->__('Invalid form data.'));
            }
            
            $this->processOrder($post);
            
            $message = $this->__('Your form has been submitted successfully.');
            Mage::getSingleton('adminhtml/session')->addSuccess($message);
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*');
    }
	
	public function getlabsAction()
    {
    	$zipCode = $this->getRequest()->getPost('zip_code');
    	$stateModel = Mage::getModel('pricing/pricing')->getCollection()->addFieldToFilter('zip_code',array('eq'=>$zipCode));
    	$state = $stateModel->getFirstItem()->getState();

        if (Mage::helper('medivo')->isStateAllowed($state)) {
            Mage::getSingleton('core/session')->setIsNnr(0);
        }
        elseif (Mage::helper('medivo')->isNNRState($state)) {
			
			Mage::getSingleton('core/session')->setIsNnr(1);
			
		} else {

        }

    	$this->loadLayout();     
		$this->renderLayout();
    }
	
	public function processOrder($post) {
		
		$storeModel = Mage::getModel('core/store')->load($post['source'],'code');
		
		$storeId = $storeModel->getId();
		
		$websiteId = $storeModel->getWebsiteId();
				
		$cartModel = Mage::getModel('checkout/cart_api');
				
		$shoppingCartId = $cartModel->create($post['source']);
		 
		// Set customer, for example guest
		$customer = array(
		    "firstname" => $post['customer-fname'],
		    "lastname" => $post['customer-lname'],
		    "email" => $post['customer-email'],
		    "gender" => $post['customer-gender'],
		    "dob" => '',
		    "group_id" => 0,
		    "website_id" => $websiteId,
		    "store_id" => $storeId,
		    "password_hash" => md5('asdf1234')
		);
		
		$customerModel = Mage::getModel('customer/customer_api');
		
		$customerId = $customerModel->create($customer);
		
		$fullCust = Mage::getModel('customer/customer')->load($customerId);
	
		$fullCust['mode'] = "customer";
		
		$cartCustomerModel = Mage::getModel('checkout/cart_customer_api');
				
		$cartCustomerModel->set($shoppingCartId,$fullCust,$post['source']);
		 
		// Set customer addresses, for example guest's addresses
		$arrAddresses = array(
		    array(
		        "mode" => "shipping",
		        "firstname" => $post['customer-fname'],
		        "lastname" => $post['customer-lname'],
		        "company" => "testCompany",
		        "street" => $post['customer-address1'],
		        "city" => $post['customer-city'],
		        "region" => $post['state'],
		        "postcode" => $post['customer-zipcode'],
		        "country_id" => "US",
		        "telephone" => $post['customer-phone'],
		        "fax" => "",
		        "is_default_shipping" => 1,
		        "is_default_billing" => 1
		    ),
		    array(
		        "mode" => "billing",
		        "firstname" => $post['customer-fname'],
		        "lastname" => $post['customer-lname'],
		        "company" => "testCompany",
		        "street" => $post['customer-address1'],
		        "city" => $post['customer-city'],
		        "region" => $post['state'],
		        "postcode" => $post['customer-zipcode'],
		        "country_id" => "US",
		        "telephone" => $post['customer-phone'],
		        "fax" => "",
		        "is_default_shipping" => 1,
		        "is_default_billing" => 1
		    )
		);
		
		$cartCustomerModel->setAddresses($shoppingCartId,$arrAddresses,$post['source']);
		
		foreach ($post['products'] as $k=>$v) {
			
			$tmp['product_id'] = $k;
			$tmp['qty'] = 1;
			
			$arrProducts[] = $tmp;
		}
				 
		
		$cartProductModel = Mage::getModel('checkout/cart_product_api');
		
		$cartProductModel->add($shoppingCartId, $arrProducts, $post['source']);
		
		$cartShippingModel = Mage::getModel('checkout/cart_shipping_api');
		 
		$cartShippingModel->setShippingMethod($shoppingCartId, 'freeshipping_freeshipping', $post['source']);
		 		 
		$cartPaymentModel = Mage::getModel('checkout/cart_payment_api');
		
		$resultPaymentMethods = $cartPaymentModel->getPaymentMethodsList($shoppingCartId, $post['source']);
	
		// ->setCcType($data->getCcType())
            // ->setCcOwner($data->getCcOwner())
            // ->setCcLast4(substr($data->getCcNumber(), -4))
            // ->setCcNumber($data->getCcNumber())
            // ->setCcCid($data->getCcCid())
            // ->setCcExpMonth($data->getCcExpMonth())
            // ->setCcExpYear($data->getCcExpYear())
            // ->setCcSsIssue($data->getCcSsIssue())
            // ->setCcSsStartMonth($data->getCcSsStartMonth())
            // ->setCcSsStartYear($data->getCcSsStartYear());
		
		$post['expyear'] = 2000 + $post['expyear'];
		 		 
		$paymentMethod = array(
		    "method" => "authorizenet",
		    "cc_owner" => $post['customer-fname']." ".$post['customer-lname'],
		    "cc_number" => $post['ccnumber'],
		    "cc_last4" => substr($post['ccnumber'], -4),
		    "cc_type" => "VI",
		    "cc_cid" => $post['cvv2'],
		    "cc_exp_month" => $post['expmon'],
		    "cc_exp_year" => $post['expyear']
		);

		
		$cartPaymentModel->setPaymentMethod($shoppingCartId, $paymentMethod, $post['source']);
				 
		// add coupon
		// $couponCode = "aCouponCode";
		// $resultCartCouponRemove = $proxy->call($sessionId, "cart_coupon.add", array($shoppingCartId, $couponCode));
		 
		// check if license is existed
		$licenseForOrderCreation = null;
		
		$resultOrderCreation = $cartModel->createOrder($shoppingCartId, $post['source'], $licenseForOrderCreation);
		
	}
	
}
