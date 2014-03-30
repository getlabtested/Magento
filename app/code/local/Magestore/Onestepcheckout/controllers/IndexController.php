<?php
class Magestore_Onestepcheckout_IndexController extends Mage_Core_Controller_Front_Action
{
    const ERROR_INVALID_DOB_DATA = 'The dob field was invalid during order placement.';

    public function indexAction() {
        if(!Mage::helper('magenotification')->checkLicenseKey('Onestepcheckout')){
            Mage::getSingleton('core/config')->saveConfig('onestepcheckout/general/active',0);
            Mage::getSingleton('checkout/session')->setSkipUpsell(true);
            return $this->_redirect('checkout/onepage');
        }
        if (!Mage::helper('onestepcheckout')->enabledOnestepcheckout()) {
            Mage::getSingleton('checkout/session')->setSkipUpsell(true);
            $this->_redirect('checkout/onepage');
            return;
        }
        $quote = $this->getOnepage()->getQuote();
        if (!$quote->hasItems() || $quote->getHasError()) {
            $this->_redirect('checkout/cart');
            return;
        }
        if (!$quote->validateMinimumAmount()) {
            $error = Mage::getStoreConfig('sales/minimum_order/error_message');
            Mage::getSingleton('checkout/session')->addError($error);
            $this->_redirect('checkout/cart');
            return;
        }

        $this->loadLayout();

        if (Mage::getModel('core/session')->getMobileVersion() == 4) {
            $this->getLayout()->getBlock('onestepcheckout')->setTemplate('onestepcheckout/onestepcheckout-m04.phtml');
        } else if (Mage::getModel('core/session')->getMobileVersion() == 5) {
            $this->getLayout()->getBlock('onestepcheckout')->setTemplate('onestepcheckout/onestepcheckout-m05.phtml');
        } else {
            $this->getLayout()->getBlock('onestepcheckout')->setTemplate('onestepcheckout/onestepcheckout.phtml');
        }
        $this->getLayout()->getBlock('head')->setTitle($this->__('Confirm Your Order & Purchase Your STD Testing Package'));
        $this->renderLayout();
    }

    //check if email is registered
    private function _emailIsRegistered($email_address) {
        $model = Mage::getModel('customer/customer');
        $model->setWebsiteId(Mage::app()->getStore()->getWebsiteId())->loadByEmail($email_address);
        if ($model->getId()) {
            return true;
        }
        else {
            return false;
        }
    }
    
    public function getOnepage() {
        return Mage::getSingleton('checkout/type_onepage');
    }
    
    public function getSession() {
        return Mage::getSingleton('checkout/session');
    }
    
    /*
    * check if an email is valid
    */
    public function is_valid_emailAction() {
        $validator = new Zend_Validate_EmailAddress();
        $email_address = $this->getRequest()->getPost('email_address');
        $message = 'Invalid';
        if ($email_address != '') {
            // Check if email is in valid format
            if(!$validator->isValid($email_address)) {
                $message = 'invalid';
            }
            else {
                //if email is valid, check if this email is registered
                if($this->_emailIsRegistered($email_address)) {
                    $message = 'exists';
                }
                else {
                    $message = 'valid';
                }
            }
        }
        $result = array('message' => $message);
        $this->getResponse()->setBody(Zend_Json::encode($result));
    }
    
    public function show_loginAction() {
        $this->loadLayout();
        $this->renderLayout();
    }
    
    public function show_passwordAction() {
        $this->loadLayout();
        $this->renderLayout();
    }
    
    /*
    * send new password to customer 
    */
    public function retrievePasswordAction() {
        $email = $this->getRequest()->getPost('email', false);
        $result = array();
        if ($email) {
            $customer = Mage::getModel('customer/customer')
                ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                ->loadByEmail($email); 
            if ($customer->getId()) {
                try {
                    $newPassword = $customer->generatePassword();
                    $customer->changePassword($newPassword, false);
                    $customer->sendPasswordReminderEmail();
                    $result = array('success' => true);
                }
                catch (Exception $e){
                    $result = array('success' => false, 'error' => $e->getMessage());
                }
            }
            else {
                $result = array('success' => false, 'error' => 'This email address was not found in our records.');
            }
        }
        $this->getResponse()->setBody(Zend_Json::encode($result));
    }
    
    /*
    * show term and condition pop up
    */
    public function show_term_conditionAction() {
        $helper = Mage::helper('onestepcheckout');
        if ($helper->enableTermsAndConditions()) {
            $html = $helper->getTermsConditionsHtml();
            echo $html;
            echo '<p class="a-right"><a href="#" onclick="javascript:TINY.box.hide();return false;">Close</a></p>';
        }
    }
    
    /*
    * add coupon to the order
    * copy from CartController.php
    */
    public function addcouponAction() {
        $couponCode = (string)$this->getRequest()->getPost('coupon_code', '');

        $suc = 0;
        $quote = $this->getOnepage()->getQuote();
        if ($this->getRequest()->getParam('remove') == '1') {
            $couponCode = '';
        }

        $oldCouponCode = $quote->getCouponCode();
        if (!strlen($couponCode) && !strlen($oldCouponCode)) {
            return;
        }

        try
        {
            $error = false;
            $quote->getShippingAddress()->setCollectShippingRates(true);
            $quote->setCouponCode(strlen($couponCode) ? $couponCode : '')
                ->collectTotals()
                ->save();
            if ($couponCode) {
                if ($couponCode == $quote->getCouponCode()) {
                    $message = $this->__('Coupon code "%s" was applied.', Mage::helper('core')->htmlEscape($couponCode));
                    $suc = 1;
                }
                else {
                    $error = true;
                    $message = $this->__('Coupon code "%s" is not valid.', Mage::helper('core')->htmlEscape($couponCode));
                }
            }
            else {
                $message = $this->__('Coupon code was canceled.');
                $suc = 1;
            }
        }
        catch(Mage_Core_Exception $e) {
            $error = true;
            $message = $e->getMessage();
        }
        catch (Exception $e) {
            $error = true;
            $message = $this->__('Cannot apply the coupon code.');
        }
        //reload HTML for review order section
        $reviewHtml = $this->_getReviewTotalHtml();        
        $result = array(
            'error' => $error,
            'message' => $message,
            'review_html' => $reviewHtml
        );

        if ($suc == 1) {
            $result = $quote->getGrandTotal();
            $result = round($result, 2);
        } else {
            $result = 0;
        }

        $this->getResponse()->setBody($result);
    }
    
    /*
    * process login action in check out.
    */
    public function loginPostAction() {
        $email = $this->getRequest()->getPost('email', false);
        $password = $this->getRequest()->getPost('password', false);

        $error = '';
        if ($email && $password) {
            try {
                $this->_getCustomerSession()->login($email, $password);
            }
            catch(Exception $ex) {
                $error = $ex->getMessage();
            }
        }
        $result = array();
        $result['error'] = $error;
        if ($error == '') $result['success'] = true;
        $this->getResponse()->setBody(Zend_Json::encode($result));
    }
    
    /*
    * save billing & shipping address
    */
    public function save_addressAction()
    {
        $billing_data = $this->getRequest()->getPost('billing', false);
        $shipping_data = $this->getRequest()->getPost('shipping', false);
        $shipping_method = $this->getRequest()->getPost('shipping_method', false);
        $billing_address_id = $this->getRequest()->getPost('billing_address_id', false);

        //load default data for disabled fields
        if (Mage::helper('onestepcheckout')->isUseDefaultDataforDisabledFields()) {
            Mage::helper('onestepcheckout')->setDefaultDataforDisabledFields($billing_data);
            Mage::helper('onestepcheckout')->setDefaultDataforDisabledFields($shipping_data);
        }

        if (isset($billing_data['use_for_shipping']) && $billing_data['use_for_shipping'] == '1') {
            $shipping_address_data = $billing_data;
        }
        else {
            $shipping_address_data = $shipping_data;
        }

        $billing_street = trim(implode("\n", $billing_data['street']));
        $shipping_street = trim(implode("\n", $shipping_address_data['street']));

        if(isset($billing_data['email'])) {
            $billing_data['email'] = trim($billing_data['email']);
        }

        // Ignore disable fields validation --- Only for 1..4.1.1
        $this->setIgnoreValidation();
        $this->getOnepage()->saveBilling($billing_data, $billing_address_id);

        // if different shipping address is enabled and customer ship to another address, save it
        if(Mage::helper('onestepcheckout')->isShowShippingAddress()) {
            if(!isset($billing_data['use_for_shipping']) || $billing_data['use_for_shipping'] != '1') {
                $shipping_address_id = $this->getRequest()->getPost('shipping_address_id', false);
                $this->getOnepage()->saveShipping($shipping_data, $shipping_address_id);
            }
        }

        if ($shipping_method && $shipping_method != '') {
            Mage::helper('onestepcheckout')->saveShippingMethod($shipping_method);
        }

        $this->loadLayout(false);
        $this->renderLayout();    
    }
    
    /*
    * save shipping & payment method 
    */
    public function save_shippingAction() {
        $shipping_method = $this->getRequest()->getPost('shipping_method', '');
        $payment_method = $this->getRequest()->getPost('payment_method', false);
        $old_shipping_method = $this->getOnepage()->getQuote()->getShippingAddress()->getShippingMethod();
        if ($shipping_method && $shipping_method != '' && $shipping_method != $old_shipping_method) {
            ////Mage::helper('onestepcheckout')->saveShippingMethod($shipping_method);
            $this->getOnepage()->saveShippingMethod($shipping_method);
        }

        if ($payment_method != '') {
            try{
                $payment = $this->getRequest()->getPost('payment', array());
                $payment['method'] = $payment_method;
                Mage::helper('onestepcheckout')->savePaymentMethod($payment);
            }
            catch(Exception $e) {
            }
        }
        
        // $paymentHtml = $this->_getPaymentMethodsHtml();
        // $reviewHtml = $this->_getReviewTotalHtml();
        // $result = array('payment' => $paymentHtml, 
        // 'review' => $reviewHtml);
        // $this->getResponse()->setBody(Zend_Json::encode($result));
        $this->loadLayout(false);
        $this->renderLayout();
    }
    
    public function saveOrderAction()
    {
        $post = $this->getRequest()->getPost();
        if (!$post) {
            return;
        }
        $error = false;
        $helper = Mage::helper('onestepcheckout');

        foreach ($post as $k=>$v) {
            if ($k != 'payment') {
                $tpost[$k] = $v;
            }
        }
        // Check which state was selected
        if (isset($post['billing']) && isset($post['billing']['region_id']))
        {
            $region_id = $post['billing']['region_id'];
            $region = Mage::getModel('directory/region')->load($region_id);
            $state = $region->getCode();
        }
        else
        {
            $state = '';
        }

        // If this is a lab test, make sure that a lab location was chosen
        if(
            Mage::getModel('checkout/cart')->getQuote()->getIsVirtual()
            && !Mage::getModel('core/session')->getScript()
        )
        {
            if (empty($state))
            {
                Mage::getSingleton('checkout/session')->addError(
                    Mage::helper('onestepcheckout')->__('There was an error processing your state. Please try again.')
                );
                Mage::getSingleton('checkout/session')->setSkipUpsell(true);
                $this->_redirect('checkout/onepage');
                Mage::app()->getResponse()->sendResponse();
                exit;
            }
            if (Mage::helper('medivo')->isStateNotAllowed($state))
            {
                Mage::getSingleton('checkout/session')->addError(
                    Mage::helper('onestepcheckout')->__(Mage::helper('medivo')->getUnallowedStatesPricingMessage())
                );
                Mage::getSingleton('checkout/session')->setSkipUpsell(true);
                $this->_redirect('checkout/onepage');
                Mage::app()->getResponse()->sendResponse();
                exit;
            }

            if (!Mage::helper('medivo')->validateLabTestData($post))
            {
                Mage::getSingleton('checkout/session')->addError(
                    Mage::helper('onestepcheckout')->__('Please select a lab location before placing order.')
                );
                Mage::getSingleton('checkout/session')->setSkipUpsell(true);
                $this->_redirect('checkout/onepage');
                Mage::app()->getResponse()->sendResponse();
                exit;
            }

            // Ensure that the necessary quote and session data had been set regarding this lab location
            $required_data_exists = Mage::helper('medivo')->setLabSpecificSessionData($post['lab_id']);
            if (!$required_data_exists)
            {
                Mage::getSingleton('checkout/session')->addError(
                    Mage::helper('onestepcheckout')->__('Please re-select your lab location before placing order.')
                );
                Mage::getSingleton('checkout/session')->setSkipUpsell(true);
                $this->_redirect('checkout/onepage');
                Mage::app()->getResponse()->sendResponse();
                exit;
            }
        }

        Mage::getSingleton('customer/session')->setTmpPost($tpost);
        Mage::getSingleton('core/session')->setPostWithBirthday($tpost);

        // Check the dob fields
        $dob_month = intval($tpost['m_select']);
        $valid_month = (!empty($dob_month) && ($dob_month > 0));
        $dob_day = intval($tpost['d_select']);
        $valid_day = (!empty($dob_day) && ($dob_day > 0));
        $dob_year = intval($tpost['y_select']);
        $valid_year = (!empty($dob_year) && ($dob_year > 0));

        if ((!$valid_month) || (!$valid_day) || (!$valid_year))
        {
            $error_message = self::ERROR_INVALID_DOB_DATA;
            Mage::log($error_message, Zend_Log::ERR, 'invalid_dob.log');
            Mage::log($_SERVER['HTTP_USER_AGENT'], Zend_Log::ERR, 'invalid_dob.log');
            Mage::log($post, Zend_Log::ERR, 'invalid_dob.log');
        }

        // Record whether the customer opted in to emails
        $opted_in = $this->getRequest()->getParam('opted_in_to_emails');
        Mage::getSingleton('customer/session')->setData('opted_in_to_emails', $opted_in);

        $qd = $this->getOnepage()->getQuote()->getData();
        foreach ($qd as $k=>$v) {
            if ($v && $v != "") {
                Mage::getSingleton('core/session')->setData($k,$v);
            }
        }

        Mage::getSingleton('core/session')->setPpmdNotify($this->getRequest()->getPost('ppmd_notify'));    
    
        $billing_data = $this->getRequest()->getPost('billing', array());
        $shipping_data = $this->getRequest()->getPost('shipping', array());

        $zipCode = $billing_data['postcode'];
        $stateModel = Mage::getModel('pricing/pricing')->getCollection()->addFieldToFilter('zip_code',array('eq'=>$zipCode));
        $state = $stateModel->getFirstItem()->getState();

        $q = $this->getOnepage()->getQuote();
        $q->setAffiliateId(Mage::getSingleton('core/session')->getAffiliateId());
        $q->setPpmdAffiliate(Mage::getSingleton('core/session')->getAffiliateId());
                
        if (Mage::getSingleton('core/session')->getOrderType() == 2) {
            if (!Mage::getSingleton('core/session')->getOrderState())
            {
                Mage::getSingleton('core/session')->setZip($zipCode);
                Mage::getSingleton('core/session')->setOrderState($state);
                $q->setOrderState($state);
            }
        }

        $pl = $q->getProductLine();
        $q->save();

        if (Mage::helper('medivo')->isNNRState($state) && ($q->getProductLine() != 2)) {
            Mage::getSingleton('core/session')->setIsNnr(1);
            $q->setIsNnr(1)->save();
            if (Mage::getSingleton('core/session')->getOrderType() == 2) {
                foreach (Mage::getSingleton('core/session')->getCartArr() as $k=>$v) {
                    if ($v != 4) {
                        $redirect = Mage::getUrl('std-testing-options');
                        Header('Location: ' . $redirect);
                        exit();
                    }
                    $this->getOnepage()->getQuote()->setPpmdProvider(3)->save();
                }
            }
        }
        else
        {
            Mage::getSingleton('core/session')->setIsNnr(0);
        }

        //set checkout method 
        $checkoutMethod = '';
        if (!$this->_isLoggedIn()) {
            $checkoutMethod = 'guest';
            if ($helper->enableRegistration() || !$helper->allowGuestCheckout()) {
                $is_create_account = $this->getRequest()->getPost('create_account_checkbox');
                $email_address = $billing_data['email'];
                if ($is_create_account || !$helper->allowGuestCheckout()) {
                    if ($this->_emailIsRegistered($email_address)) {
                        // Attempt to log the customer in
                        if (Mage::helper('onestepcheckout')->forceCustomerLogin($email_address))
                        {
                            $checkoutMethod = Mage_Checkout_Model_Type_Onepage::METHOD_CUSTOMER;
                        }
                        else
                        {
                            $error = true;
                            Mage::log("ERROR: ".__METHOD__.":".__LINE__);
                            //$this->getLayout()->getMessagesBlock()->addError(Mage::helper('onestepcheckout')->__('Email is already registered.'));
                            Mage::getSingleton('checkout/session')->addError(Mage::helper('onestepcheckout')->__('E-mail address already registered.  Please log-in to save 5% or try a different e-mail address.'));
                            Mage::getSingleton('core/session')->setPreventUpsellPage(1);
                            Mage::getSingleton('checkout/session')->setSkipUpsell(true);
                            $this->_redirect('checkout/onepage');
                            Mage::app()->getResponse()->sendResponse();
                            exit;
                        }
                    }
                    else {
                        if (!$billing_data['customer_password'] || $billing_data['customer_password'] == '') {
                            $error = true;                            
                        }
                        else if (!$billing_data['confirm_password'] || $billing_data['confirm_password'] == '') {
                            $error = true;
                        }
                        else if ($billing_data['confirm_password'] !== $billing_data['customer_password']) {
                            $error = true;
                        }
                        if ($error) {
                            Mage::getSingleton('checkout/session')->addError(Mage::helper('onestepcheckout')->__('Please correct your password.'));
                            Mage::getSingleton('checkout/session')->setSkipUpsell(true);
                            $this->_redirect('checkout/onepage');
                        }
                        else {
                            $checkoutMethod = 'register';
                        }
                    }
                }
            }
        }
        if ($checkoutMethod != '') {
            $this->getOnepage()->saveCheckoutMethod($checkoutMethod);
        }

        //to ignore validation for disabled fields
        $this->setIgnoreValidation();

        //resave billing address to make sure there is no error if customer change something in billing section before finishing order
        $customerAddressId = $this->getRequest()->getPost('billing_address_id', false);
        $result = $this->getOnepage()->saveBilling($billing_data, $customerAddressId);

        if(isset($result['error'])) {
            $error = true;
            if (is_array($result['message']) && isset($result['message'][0])){
                Mage::getSingleton('checkout/session')->addError($result['message'][0]);
            }
            else {
                Mage::getSingleton('checkout/session')->addError($result['message']);
            }
            Mage::getSingleton('checkout/session')->setSkipUpsell(true);
            $this->_redirect('checkout/onepage');
        }

        //re-save shipping address
        $shipping_address_id = $this->getRequest()->getPost('shipping_address_id', false);
        //if($helper->isShowShippingAddress()) {
        //    if(!isset($billing_data['use_for_shipping']) || $billing_data['use_for_shipping'] != '1') {
        //        $result = $this->getOnepage()->saveShipping($shipping_data, $shipping_address_id);
        //        if(isset($result['error'])) {
        //            $error = true;
        //            if (is_array($result['message']) && isset($result['message'][0]))
        //                Mage::getSingleton('checkout/session')->addError($result['message'][0]);
        //            else 
        //                Mage::getSingleton('checkout/session')->addError($result['message']);
        //            $this->_redirect('*/*/index');
        //        }
        //    }
        //    else {
                $result = $this->getOnepage()->saveShipping($billing_data, $shipping_address_id); 
        //    }
        //}
        //re-save shipping method
        $shipping_method = $this->getRequest()->getPost('shipping_method', '');
        if(!$this->isVirtual()) {
            $result = $this->getOnepage()->saveShippingMethod($shipping_method);
            if(isset($result['error'])) {
                $error = true;
                if (is_array($result['message']) && isset($result['message'][0])) {
                    Mage::getSingleton('checkout/session')->addError($result['message'][0]);
                }
                else {
                    Mage::getSingleton('checkout/session')->addError($result['message']);
                }
                Mage::getSingleton('checkout/session')->setSkipUpsell(true);
                $this->_redirect('checkout/onepage');
            }
            else {
                Mage::dispatchEvent('checkout_controller_onepage_save_shipping_method', array('request'=>$this->getRequest(), 'quote'=>$this->getOnepage()->getQuote()));
            }
        }

        $paymentRedirect = false;
        //save payment method
        try {
            $result = array();
            $payment = $this->getRequest()->getPost('payment', array());
            $result = $helper->savePaymentMethod($payment);
            if($payment){
                $this->getOnepage()->getQuote()->getPayment()->importData($payment);
            }
            $paymentRedirect = $this->getOnepage()->getQuote()->getPayment()->getCheckoutRedirectUrl();
        }
        catch (Mage_Payment_Exception $e) {
            Mage::logException($e);
            if ($e->getFields()) {
                $result['fields'] = $e->getFields();
            }
            $result['error'] = $e->getMessage();
        } catch (Mage_Core_Exception $e) {
            Mage::logException($e);
            $result['error'] = $e->getMessage();
        } catch (Exception $e) {
            Mage::logException($e);
            $result['error'] = $this->__('Unable to set Payment Method.');
        }
        if (isset($result['error'])) {
            $error = true;
            Mage::getSingleton('checkout/session')->addError($result['error']);
            Mage::getSingleton('core/session')->addError($result['error']);
            Mage::getSingleton('checkout/session')->setSkipUpsell(true);
            $this->_redirect('checkout/onepage');
        }
        if ($paymentRedirect && $paymentRedirect != '') {
            Header('Location: ' . $paymentRedirect);
            exit();
        }

        //only continue to process order if there is no error
        if (!$error) {
            //newsletter subscribe
            if ($helper->isShowNewsletter()) {
                $is_subscriber = $this->getRequest()->getPost('newsletter_subscriber_checkbox', false);
                if ($is_subscriber) {
                    $subscribe_email = '';
                    //pull subscriber email from billing data
                    if (isset($billing_data['email']) && $billing_data['email'] != '') {
                        $subscribe_email = $billing_data['email'];
                    }
                    else if ($this->_isLoggedIn()) {
                        $subscribe_email = Mage::helper('customer')->getCustomer()->getEmail();
                    }
                    //check if email is already subscribed
                    $subscriberModel = Mage::getModel('newsletter/subscriber')->loadByEmail($subscribe_email);
                    if ($subscriberModel->getId() === NULL) {
                        Mage::getModel('newsletter/subscriber')->subscribe($subscribe_email);
                    }
                }
            }
            Mage::helper('onestepcheckout')->finalizeOrder();
        }
        else {
            Mage::getSingleton('checkout/session')->setSkipUpsell(true);
            $this->_redirect('checkout/onepage');
        }
    }

    protected function _getCustomerSession() {
        return Mage::getSingleton('customer/session');
    }

    /*
    * Reload shipping method html
    */
    protected function _getShippingMethodsHtml() {
        //$this->_cleanLayoutCache();
        $layout = $this->getLayout();
        $update = $layout->getUpdate();
        $update->load('onestepcheckout_onestepcheckout_shippingmethod');
        $layout->generateXml();
        $layout->generateBlocks();
        $output = $layout->getOutput();
        return $output;
    }

    /*
    * Reload payment method html
    */
    public function _getPaymentMethodsHtml() {
        //$this->_cleanLayoutCache();
        $layout = $this->getLayout();
        $update = $layout->getUpdate();
        $update->load('onestepcheckout_onestepcheckout_paymentmethod');
        $layout->generateXml();
        $layout->generateBlocks();
        $output = $layout->getOutput();
        return $output;
    }

    public function _getReviewTotalHtml() {
        //$this->_cleanLayoutCache();
        $layout = $this->getLayout();
        $update = $layout->getUpdate();
        $update->load('onestepcheckout_onestepcheckout_review');
        $layout->unsetBlock('shippingmethod');
        $layout->generateXml();
        $layout->generateBlocks();
        $output = $layout->getOutput();
        return $output;
    }

    protected function _isLoggedIn() {
        return $this->_getCustomerSession()->isLoggedIn();
    }

    public function isVirtual() {
        return $this->getOnepage()->getQuote()->isVirtual();
    }

    /*
    * this function is to pass the validation 
    * Only available for Magento 1.4.x 
    */
    public function setIgnoreValidation() {
        $this->getOnepage()->getQuote()->getBillingAddress()->setShouldIgnoreValidation(true);
        $this->getOnepage()->getQuote()->getShippingAddress()->setShouldIgnoreValidation(true);
    }

    protected function _cleanLayoutCache() {
        Mage::app()->cleanCache(LAYOUT_GENERAL_CACHE_TAG);
    }

    public function nnrAction() {
        $post = $this->getRequest()->getPost();
        $q = $this->getOnepage()->getQuote();
        $zipCode = $post['zip_code'];
        $stateModel = Mage::getModel('pricing/pricing')->getCollection()->addFieldToFilter('zip_code',array('eq'=>$zipCode));
        $state = $stateModel->getFirstItem()->getState();

        Mage::getSingleton('core/session')->setOrderState($state);
        Mage::getSingleton('core/session')->setZip($zipCode);
        Mage::getSingleton('core/session')->setLabZip($zipCode);

        $response_data = array();
        $response_data['is_not_allowed'] = false;
        $response_data['is_nnr'] = false;
        $response_data['nnr_medivo_states'] = '';
        $response_data['unallowed_medivo_states_message'] = '';
        $response_data['std_testing_options_url'] = '';

        $unallowed_states = Mage::helper('ppmd_tests/vendors')->getUnallowedVendorStatesByQuote($q);
        if (in_array($state, $unallowed_states))
        {
            $response_data['is_not_allowed'] = true;
            $response_data['unallowed_medivo_states_message'] = Mage::helper('ppmd_tests/vendors')->getUnallowedStateMessage($unallowed_states);
            $json_response_data = json_encode($response_data);
            echo $json_response_data;
            return;
        }

        // Shouldn't end up in this if block, but I'm leaving it in just in case
        if (Mage::helper('medivo')->isStateNotAllowed($state)) {
            // Otherwise the state is not allowed
            $response_data['is_not_allowed'] = true;
            $response_data['unallowed_medivo_states_message'] = Mage::helper('medivo')->getUnallowedStatesPricingMessage();
            $json_response_data = json_encode($response_data);
            echo $json_response_data;
            return;
        }

        if (Mage::helper('medivo')->isNNRState($state) && (Mage::getSingleton('core/session')->getIsNnr() == 0)) {
            Mage::getSingleton('core/session')->setIsNnr(1);
            $q->setIsNnr(1);
            $q->setPpmdProvider(2);
            $q->setOrderState($state);
            $q->setLabZip($zipCode);
            $q->save();
            Mage::getSingleton('core/session')->setOrderState($state);

            foreach ($q->getAllItems() as $item) {
                if (($item->getSku() == 'hiv-home') || ($item->getSku() == 'nnr-hiv-home')) {
                    //nothing
                } else {
                    $response_data['is_nnr'] = true;
                    $response_data['nnr_medivo_states'] = Mage::helper('medivo')->getNnrStatesString();
                    $response_data['std_testing_options_url'] = Mage::getModel('core/url')->getUrl().'std-testing-options';
                    $json_response_data = json_encode($response_data);
                    echo $json_response_data;
                    return;
                }
            }
        }

        // State is allowed, or we have established that this is an nnr checkout
        $json_response_data = json_encode($response_data);
        echo $json_response_data;
        return;

    }
}
