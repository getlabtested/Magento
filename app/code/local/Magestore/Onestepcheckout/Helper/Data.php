<?php
class Magestore_Onestepcheckout_Helper_Data extends Mage_Core_Helper_Abstract {

    const NON_CUSTOMER_CHECKOUT_WEBSITE_CODES_CONFIG = 'onestepcheckout/non_custom_website_codes';
    const REGION_ID_DATA_CONFIG_PATH = 'onestepcheckout/customer/states';
    const BIRTHDAY_MONTH_DATA_CONFIG_PATH = 'onestepcheckout/customer/birthday_months';
    const ONESTEPCHECKOUT_ROUTE_CONFIG_PATH = 'onestepcheckout/checkout_page/route';

    protected $_state_data = null;
    protected $_login_url = null;
    protected $_login_post_url = null;
    protected $_forgot_password_url = null;
    protected $_retrieve_password_url = null;
    protected $_add_coupon_url = null;
    protected $_last_order = null;

	public function __construct() {
		$this->settings = $this->getConfigData();
	}
	
	public function enabledOnestepcheckout() {
		if (Mage::getStoreConfig('onestepcheckout/general/active')) {
			return true;
		}
		return false;
	}

    public function isCustomCheckoutWebsite()
    {
        $current_website = Mage::app()->getWebsite();
        return !in_array($current_website->getCode(), array_keys(Mage::getStoreConfig(self::NON_CUSTOMER_CHECKOUT_WEBSITE_CODES_CONFIG)));
    }


    public function getSecureCheckoutUrl()
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK, true).'onestepcheckout/index/';
    }


	public function enableRegistration() {
		if ($this->settings['enable_registration']) {
			return true;
		}
		return false;
	}
	
	public function loadDataforDisabledFields(&$data) {
		$configData = $this->getConfigData();
		if (!$configData['show_city']) {
			$data['city'] = '-';
		}
		if (!$configData['show_zipcode']) {
			$data['postcode'] = '-';
		}
		if (!$configData['show_company']) {
			$data['company'] = '';
		}
		if (!$configData['show_fax']) {
			$data['fax'] = '';
		}
		if (!$configData['show_telephone']) {		
			$data['telephone'] = '-';
		}
		if (!$configData['show_region']) {
			$data['region'] = '-';
			$data['region_id'] = '-';
		}
		return $data;
	}
	
	public function loadEmptyData(&$data) {
		if (!isset($data['city']) || $data['city'] == '') {
			if ($this->settings['city'] != '') {
				$data['city'] = $this->settings['city'];
			}
			else {
				$data['city'] = '-';
			}
		}
		if (!isset($data['telephone']) || trim($data['telephone']) == '') {
			$data['telephone'] = '-';
		}
		if (!isset($data['postcode']) || $data['postcode'] == '') {
			if ($this->settings['postcode'] != '') {
				$data['postcode'] = $this->settings['postcode'];
			}
			else {
				$data['postcode'] = '-';
			}
		}
		if (!isset($data['region']) || $data['region'] == '') {
			$data['region'] = '-';
		}		
		if (!isset($data['region_id']) || $data['region_id'] == '') {
			if ($this->settings['region_id'] != '') {
				$data['region_id'] = $this->settings['region_id'];
			}
			else {
				$data['region_id'] = '-';
			}
		}
		if (!isset($data['country_id']) || $data['country_id'] == '') {
			if ($this->settings['country_id'] != '') {
				$data['country_id'] = $this->settings['country_id'];
			}
			else {
				$data['country_id'] = '-';
			}
		}		
		return $data;
	}
	
	public function getConfigData() {
		$configData = array();
		$configItems = array('general/active', 'general/checkout_title', 'general/checkout_description',
													'general/show_shipping_address', 'general/country_id',
													'general/default_payment', 'general/default_shipping',
													'general/postcode', 'general/region_id', 'general/city',
													'general/use_for_disabled_fields', 'general/hide_shipping_method',
													'general/page_layout',
													'field_management/show_city', 'field_management/show_zipcode',
													'field_management/show_company', 'field_management/show_fax',
													'field_management/show_telephone', 'field_management/show_region',
													'field_management/show_comment', 'field_management/show_newsletter',
													'field_management/show_discount', 'field_management/newsletter_default_checked',
													'field_management/enable_giftmessage',
													'checkout_mode/show_login_link', 'checkout_mode/enable_registration',
													'checkout_mode/allow_guest', 'checkout_mode/login_link_title',
													'ajax_update/enable_ajax', 'ajax_update/ajax_fields', 
													'ajax_update/update_payment', 
													'ajax_update/reload_payment',
													'terms_conditions/enable_terms', 'terms_conditions/term_html', 
													'terms_conditions/term_width', 'terms_conditions/term_height',
													'order_notification/enable_notification', 'order_notification/notification_email');
		foreach ($configItems as $configItem) {
			$config = explode('/', $configItem);
			$value = $config[1];
			$configData[$value] = Mage::getStoreConfig('onestepcheckout/' . $configItem);
		}		
		return $configData;
	}
	
	public function isShowShippingAddress() {
		if($this->getOnepage()->getQuote()->isVirtual())	{
			return false;
		}
		if($this->settings['show_shipping_address'])	{
			return true;
		}
		return false;
	}
	
	public function getOnePage() {
		return Mage::getSingleton('checkout/type_onepage');
	}

	public function getCheckoutUrl() {
		return Mage::getUrl('onestepcheckout');
	}

	public function savePaymentMethod($data) {
		if (empty($data)) {
			return array('error' => -1, 'message' => Mage::helper('checkout')->__('Invalid data.'));
		}
		$onepage = Mage::getSingleton('checkout/session')->getQuote();
		if ($onepage->isVirtual()) {
			$onepage->getBillingAddress()->setPaymentMethod(isset($data['method']) ? $data['method'] : null);
		} else {
			$onepage->getShippingAddress()->setPaymentMethod(isset($data['method']) ? $data['method'] : null);
		}
		$payment = $onepage->getPayment();
		$payment->importData($data);

		$onepage->save();
		
		return array();
	}
	
	public function saveShippingMethod($shippingMethod) {
		if (empty($shippingMethod)) {
			return array('error' => -1, 'message' => Mage::helper('checkout')->__('Invalid shipping method.'));
		}
		$rate = $this->getOnepage()->getQuote()->getShippingAddress()->getShippingRateByCode($shippingMethod);
		if (!$rate) {
			return array('error' => -1, 'message' => Mage::helper('checkout')->__('Invalid shipping method.'));
		}
		$this->getOnepage()->getQuote()->getShippingAddress()->setShippingMethod($shippingMethod);
		//$this->getOnepage()->getQuote()->collectTotals()->save();
		return array();
	}
	
	public function allowGuestCheckout() {
		$_quote = $this->getOnepage()->getQuote();		
		$_isAllowed = $this->settings['allow_guest'];
		if ($_isAllowed) {
			$isContain = false;
			foreach ($_quote->getAllItems() as $item) {
				if (($product = $item->getProduct()) &&
				$product->getTypeId() == Mage_Downloadable_Model_Product_Type::TYPE_DOWNLOADABLE) {
					$isContain = true;
				}
			}
			$store = Mage::app()->getStore()->getId();
			if ($isContain && Mage::getStoreConfigFlag('catalog/downloadable/disable_guest_checkout', $store)) {
				$_isAllowed = false;
			}
		}
		return $_isAllowed;
	}
	
	public function isUseDefaultDataforDisabledFields() {
		return $this->settings['use_for_disabled_fields'];
	}
	
	public function isShowNewsletter() {
		return $this->settings['show_newsletter'];
	}
	
	public function isSubscribeByDefault() {
		return $this->settings['newsletter_default_checked'];
	}
	
	public function enableOrderComment() {
		return $this->settings['show_comment'];
	}
	
	public function showDiscount() {
		return $this->settings['show_discount'];
	}
	
	public function enableTermsAndConditions() {
		return $this->settings['enable_terms'];
	}
	
	public function getTermPopupWidth() {
		return $this->settings['term_width'];
	}
	
	public function getTermPopupHeight() {
		return $this->settings['term_height'];
	}
	
	public function getTermsConditionsHtml() {
		return $this->settings['term_html'];
	}
	
	public function enableNotifyAdmin() {
		return $this->settings['enable_notification'];
	}
	
	public function getEmailArray() {
		$email_string = (string)$this->settings['notification_email'];
		if ($email_string != '') {
			$email_array = explode(",", $email_string);		
			return $email_array;
		}
		return array();
	}
	
	public function getEmailTemplate() {
		return Mage::getStoreConfig('onestepcheckout/order_notification/notification_email_template');
	}
	
	public function enableGiftMessage() {
		//return $this->settings['enable_giftmessage'];
		return Mage::getStoreConfig('sales/gift_messages/allow_order');
	}
	
	public function isHideShippingMethod() {
		$_isHide = $this->settings['hide_shipping_method'];
		if ($_isHide) {
			$_quote = $this->getOnepage()->getQuote();
			$rates = $_quote->getShippingAddress()->getShippingRatesCollection();
			$rateCodes = array();
			foreach($rates as $rate)    {
				if(!in_array($rate->getCode(), $rateCodes)) {
					$rateCodes[] = $rate->getCode();
				}
			}
			if(count($rateCodes) > 1)  {
				$_isHide = false;
			}
		}
		
		return $_isHide;
	}
	
	/*
	* Save customer comment to the order
	*/
	public function saveOrderComment($observer) {		
		if ($this->enableOrderComment()) {
			$comment = $this->_getRequest()->getPost('onestepcheckout_comment');
			$comment = trim($comment);			
			if ($comment != '') {
				$order = $observer->getEvent()->getOrder();						
				try {
					// use custom attribute to save customer comment - magento 1.3
					$order->setOnestepcheckoutOrderComment($comment);
					
					//Magento 1.4.1.1 - can not use custom attribute to save customer comment
					//$order->setCustomerNote($comment);
					
					//$order->save();
				}
				catch(Exception $e) {
					
				}
			}
		}
	}

	/*
	* use to load default data for disabled fields
	* only use if it is enabled
	*/
	public function setDefaultDataforDisabledFields(&$data) {
		if (!$this->settings['show_city']) {
			$data['city'] = $this->settings['city'];
		}
		if (!$this->settings['show_zipcode']) {
			$data['postcode'] = $this->settings['postcode'];
		}
		if (!$this->settings['show_region']) {
			$data['region_id'] = $this->settings['region_id'];
		}
		return $data;
	}

    public function getRegionIdData()
    {
        if (!is_null($this->_state_data))
        {
            return $this->_state_data;
        }

        $states_config = Mage::getStoreConfig(self::REGION_ID_DATA_CONFIG_PATH);
        $states = array_keys($states_config);

        $state_options = array();

        foreach($states as $state_data)
        {
            $split_on_underscores = explode("_", $state_data);
            $region_id = array_pop($split_on_underscores);
            $state_name = implode(" ", $split_on_underscores);
            $state_options[$region_id] = $state_name;
        }

        $this->_state_data = $state_options;

        return $this->_state_data;
    }
    public function getBirthdayMonthData()
    {
        $birthday_month_config = Mage::getStoreConfig(self::BIRTHDAY_MONTH_DATA_CONFIG_PATH);
        return $birthday_month_config;
    }

    public function getLoginUrl()
    {
        if (!is_null($this->_login_url))
        {
            return $this->_login_url;
        }

        $this->_login_url = $this->_getUrl('onestepcheckout/index/show_login', array('_secure' => true));
        return $this->_login_url;
    }

    public function getLoginPostUrl()
    {
        if (!is_null($this->_login_post_url))
        {
            return $this->_login_post_url;
        }

        $this->_login_post_url = $this->_getUrl('onestepcheckout/index/loginPost', array('_secure' => true));
        return $this->_login_post_url;
    }

    public function getForgotPasswordUrl()
    {
        if (!is_null($this->_forgot_password_url))
        {
            return $this->_forgot_password_url;
        }

        $this->_forgot_password_url = $this->_getUrl('onestepcheckout/index/show_password', array('_secure' => true));
        return $this->_forgot_password_url;
    }

    public function getRetrievePasswordUrl()
    {
        if (!is_null($this->_retrieve_password_url))
        {
            return $this->_retrieve_password_url;
        }

        $this->_retrieve_password_url = $this->_getUrl('onestepcheckout/index/retrievePassword', array('_secure' => true));
        return $this->_retrieve_password_url;
    }

    public function getAddCouponUrl()
    {
        if (!is_null($this->_add_coupon_url))
        {
            return $this->_add_coupon_url;
        }

        $this->_add_coupon_url = $this->_getUrl('onestepcheckout/index/addcoupon', array('_secure' => true));
        return $this->_add_coupon_url;
    }

    public function forceCustomerLogin($customer_email)
    {
        try
        {
            $customer = Mage::getModel('customer/customer')
                ->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
            $customer->loadByEmail($customer_email);

            $session = Mage::getSingleton('customer/session');
            $session->setCustomerAsLoggedIn($customer);
            $session->renewSession();
        }
        catch(Exception $e)
        {
            Mage::logException($e);
            Mage::log($e->getMessage());
            return false;
        }

        return true;
    }

    public function setAllQuoteItemsToSingleQty()
    {
        $quote = Mage::helper('checkout/cart')->getQuote();
        $quote_items = $quote->getItemsCollection();

        foreach ($quote_items as $item)
        {
            $item->setQty(1);
        }

        $quote->save();
    }

    public function getOnestepcheckoutRoute()
    {
        $route = Mage::getStoreConfig(self::ONESTEPCHECKOUT_ROUTE_CONFIG_PATH);
        return $route;
    }

    public function getLastOrder()
    {
        if (is_null($this->_last_order))
        {
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            $customer_id = $customer->getEntityId();
            $this->_last_order = Mage::getModel('sales/order')->getCollection()
                                    ->addFilter('customer_id', $customer_id)
                                    ->setOrder('created_at', Varien_Data_Collection_Db::SORT_ORDER_DESC)
                                    ->getFirstItem();
        }

        return $this->_last_order;
    }

    public function getLastOrderTotal()
    {
        $last_order = $this->getLastOrder();
        if (!is_object($last_order))
        {
            return '';
        }

        return $last_order->getGrandTotal();
    }

    public function finalizeOrder($paypal_order = null)
    {
        $onepage = Mage::getSingleton('checkout/type_onepage');

        try {
            if (is_null($paypal_order))
            {
                $result = $onepage->saveOrder();
            }
            else
            {
                $result = $onepage->savePaypalOrder($paypal_order);
            }

            $redirectUrl = $onepage->getCheckout()->getRedirectUrl();
        }
        catch (Mage_Core_Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('checkout/session')->addError('Transaction has been declined');
            //Mage::helper('checkout')->sendPaymentFailedEmail($this->getOnepage()->getQuote(), $e->getMessage());
            $redirect = Mage::getUrl('onestepcheckout/index/index',array("_secure"=>true));
            Header('Location: ' . $redirect);
            exit();
        }
        catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('checkout/session')->addError('Transaction has been declined');
            //Mage::helper('checkout')->sendPaymentFailedEmail($this->getOnepage()->getQuote(), $e->getMessage());
            $redirect = Mage::getUrl('onestepcheckout/index/index',array("_secure"=>true));
            Header('Location: ' . $redirect);
            exit();
        }

        $onepage->getQuote()->save();

        $quote = $onepage->getQuote();
        $quote_id = $quote->getEntityId();

        $order = Mage::getModel('sales/order')
            ->getCollection()
            ->addFieldToFilter('quote_id', $quote_id)
            ->getFirstItem();

        $customer_id = $order->getCustomerId();
        $customer = Mage::getModel('customer/customer')->load($customer_id);
        if (!is_object($customer))
        {
            $customer_session = Mage::getSingleton('customer/session');
            $customer = $customer_session->getCustomer();
        }

        Mage::dispatchEvent('ppmd_onestepcheckout_success', array('order' => $order, 'customer' => $customer));

        if($redirectUrl)    {
            $redirect = $redirectUrl;
        }
        else {
            $redirect = Mage::getUrl('checkout/onepage/success');
        }
        Mage::getSingleton('core/session')->setCartArr(null);
        Header('Location: ' . $redirect);
        exit();
    }
}
