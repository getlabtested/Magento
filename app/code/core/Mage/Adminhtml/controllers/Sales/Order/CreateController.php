<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 * Adminhtml sales orders creation process controller
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Sales_Order_CreateController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Additional initialization
     *
     */
    protected function _construct()
    {
        $this->setUsedModuleName('Mage_Sales');
    }

    /**
     * Retrieve session object
     *
     * @return Mage_Adminhtml_Model_Session_Quote
     */
    protected function _getSession()
    {
        return Mage::getSingleton('adminhtml/session_quote');
    }

    /**
     * Retrieve quote object
     *
     * @return Mage_Sales_Model_Quote
     */
    protected function _getQuote()
    {
        return $this->_getSession()->getQuote();
    }

    /**
     * Retrieve order create model
     *
     * @return Mage_Adminhtml_Model_Sales_Order_Create
     */
    protected function _getOrderCreateModel()
    {
        return Mage::getSingleton('adminhtml/sales_order_create');
    }

    /**
     * Retrieve gift message save model
     *
     * @return Mage_Adminhtml_Model_Giftmessage_Save
     */
    protected function _getGiftmessageSaveModel()
    {
        return Mage::getSingleton('adminhtml/giftmessage_save');
    }

    /**
     * Initialize order creation session data
     *
     * @return Mage_Adminhtml_Sales_Order_CreateController
     */
    protected function _initSession()
    {
        /**
         * Identify customer
         */
        if ($customerId = $this->getRequest()->getParam('customer_id')) {
            $this->_getSession()->setCustomerId((int) $customerId);
        }

        /**
         * Identify store
         */
        if ($storeId = $this->getRequest()->getParam('store_id')) {
            $this->_getSession()->setStoreId((int) $storeId);
        }

        /**
         * Identify currency
         */
        if ($currencyId = $this->getRequest()->getParam('currency_id')) {
            $this->_getSession()->setCurrencyId((string) $currencyId);
            $this->_getOrderCreateModel()->setRecollect(true);
        }
        return $this;
    }

    /**
     * Processing request data
     *
     * @return Mage_Adminhtml_Sales_Order_CreateController
     */
    protected function _processData()
    {
        return $this->_processActionData();
    }

    /**
     * Process request data with additional logic for saving quote and creating order
     *
     * @param string $action
     * @return Mage_Adminhtml_Sales_Order_CreateController
     */
    protected function _processActionData($action = null)
    {
        /**
         * Saving order data
         */
        if ($data = $this->getRequest()->getPost('order')) {
            $this->_getOrderCreateModel()->importPostData($data);
        }

        /**
         * Initialize catalog rule data
         */
        $this->_getOrderCreateModel()->initRuleData();

        /**
         * init first billing address, need for virtual products
         */
        $this->_getOrderCreateModel()->getBillingAddress();

        /**
         * Flag for using billing address for shipping
         */
        if (!$this->_getOrderCreateModel()->getQuote()->isVirtual()) {
            $syncFlag = $this->getRequest()->getPost('shipping_as_billing');
            if (!is_null($syncFlag)) {
                $this->_getOrderCreateModel()->setShippingAsBilling((int)$syncFlag);
            }
        }

        /**
         * Change shipping address flag
         */
        if (!$this->_getOrderCreateModel()->getQuote()->isVirtual() && $this->getRequest()->getPost('reset_shipping')) {
            $this->_getOrderCreateModel()->resetShippingMethod(true);
        }

        /**
         * Collecting shipping rates
         */
        if (!$this->_getOrderCreateModel()->getQuote()->isVirtual() && $this->getRequest()->getPost('collect_shipping_rates')) {
            $this->_getOrderCreateModel()->collectShippingRates();
        }


        /**
         * Apply mass changes from sidebar
         */
        if ($data = $this->getRequest()->getPost('sidebar')) {
            $this->_getOrderCreateModel()->applySidebarData($data);
        }

        /**
         * Adding product to quote from shopping cart, wishlist etc.
         */
        if ($productId = (int) $this->getRequest()->getPost('add_product')) {
            $this->_getOrderCreateModel()->addProduct($productId, $this->getRequest()->getPost());
        }

        /**
         * Adding products to quote from special grid
         */
        if ($this->getRequest()->has('item') && !$this->getRequest()->getPost('update_items') && !($action == 'save')) {
            $items = $this->getRequest()->getPost('item');
            $items = $this->_processFiles($items);
            $this->_getOrderCreateModel()->addProducts($items);
        }

        /**
         * Update quote items
         */
        if ($this->getRequest()->getPost('update_items')) {
            $items = $this->getRequest()->getPost('item', array());
            $items = $this->_processFiles($items);
            $this->_getOrderCreateModel()->updateQuoteItems($items);
        }

        /**
         * Remove quote item
         */
        $removeItemId = (int) $this->getRequest()->getPost('remove_item');
        $removeFrom = (string) $this->getRequest()->getPost('from');
        if ($removeItemId && $removeFrom) {
            $this->_getOrderCreateModel()->removeItem($removeItemId, $removeFrom);
        }

        /**
         * Move quote item
         */
        $moveItemId = (int) $this->getRequest()->getPost('move_item');
        $moveTo = (string) $this->getRequest()->getPost('to');
        if ($moveItemId && $moveTo) {
            $this->_getOrderCreateModel()->moveQuoteItem($moveItemId, $moveTo);
        }

        /*if ($paymentData = $this->getRequest()->getPost('payment')) {
            $this->_getOrderCreateModel()->setPaymentData($paymentData);
        }*/
        if ($paymentData = $this->getRequest()->getPost('payment')) {
            $this->_getOrderCreateModel()->getQuote()->getPayment()->addData($paymentData);
        }

        $eventData = array(
            'order_create_model' => $this->_getOrderCreateModel(),
            'request'            => $this->getRequest()->getPost(),
        );

        Mage::dispatchEvent('adminhtml_sales_order_create_process_data', $eventData);

        $this->_getOrderCreateModel()
            ->saveQuote();

        if ($paymentData = $this->getRequest()->getPost('payment')) {
            $this->_getOrderCreateModel()->getQuote()->getPayment()->addData($paymentData);
        }

        /**
         * Saving of giftmessages
         */
        $giftmessages = $this->getRequest()->getPost('giftmessage');
        if ($giftmessages) {
            $this->_getGiftmessageSaveModel()->setGiftmessages($giftmessages)
                ->saveAllInQuote();
        }

        /**
         * Importing gift message allow items from specific product grid
         */
        if ($data = $this->getRequest()->getPost('add_products')) {
            $this->_getGiftmessageSaveModel()->importAllowQuoteItemsFromProducts(Mage::helper('core')->jsonDecode($data));
        }

        /**
         * Importing gift message allow items on update quote items
         */
        if ($this->getRequest()->getPost('update_items')) {
            $items = $this->getRequest()->getPost('item', array());
            $this->_getGiftmessageSaveModel()->importAllowQuoteItemsFromItems($items);
        }

        $data = $this->getRequest()->getPost('order');
        if (!empty($data['coupon']['code'])) {
            if ($this->_getQuote()->getCouponCode() !== $data['coupon']['code']) {
                $this->_getSession()->addError($this->__('"%s" coupon code is not valid.', $data['coupon']['code']));
            } else {
                $this->_getSession()->addSuccess($this->__('The coupon code has been accepted.'));
            }
        }

        return $this;
    }

    /**
     * Process buyRequest file options of items
     *
     * @param array $items
     * @return array
     */
    protected function _processFiles($items)
    {
        /* @var $productHelper Mage_Catalog_Helper_Product */
        $productHelper = Mage::helper('catalog/product');
        foreach ($items as $id => $item) {
            $buyRequest = new Varien_Object($item);
            $params = array('files_prefix' => 'item_' . $id . '_');
            $buyRequest = $productHelper->addParamsToBuyRequest($buyRequest, $params);
            if ($buyRequest->hasData()) {
                $items[$id] = $buyRequest->toArray();
            }
        }
        return $items;
    }

    /**
     * Index page
     */
    public function indexAction()
    {
        
        $this->_title($this->__('Sales'))->_title($this->__('Orders'))->_title($this->__('New Order'));
        $this->_initSession();
        
		$this->loadLayout();
		
        $this->_setActiveMenu('sales/order')
            ->renderLayout();

		//$this->_forward('loadblock',null,null,array('block'=>'header,data'));
    }

    public function productsAction()
    {
        $this->loadLayout('adminhtml_sales_order_create_products');
        $this->renderLayout();
    }

    public function nnrProductsAction()
    {
        $this->loadLayout('adminhtml_sales_order_create_nnr_products');
        $this->renderLayout();
    }

    public function reorderAction()
    {
//        $this->_initSession();
        $this->_getSession()->clear();
        $orderId = $this->getRequest()->getParam('order_id');
        $order = Mage::getModel('sales/order')->load($orderId);

        if ($order->getId()) {
            $order->setReordered(true);
            $this->_getSession()->setUseOldShippingMethod(true);
            $this->_getOrderCreateModel()->initFromOrder($order);

            $this->_redirect('*/*');
        }
        else {
            $this->_redirect('*/sales_order/');
        }
    }

    protected function _reloadQuote()
    {
        $id = $this->_getQuote()->getId();
        $this->_getQuote()->load($id);
        return $this;
    }

    /**
     * Loading page block
     */
    public function loadBlockAction()
    {
        $request = $this->getRequest();
        try {
            $this->_initSession()
                ->_processData();
        }
        catch (Mage_Core_Exception $e){
            $this->_reloadQuote();
            $this->_getSession()->addError($e->getMessage());
        }
        catch (Exception $e){
            $this->_reloadQuote();
            $this->_getSession()->addException($e, $e->getMessage());
        }


        $asJson= $request->getParam('json');
        $block = $request->getParam('block');

        $update = $this->getLayout()->getUpdate();
        if ($asJson) {
            $update->addHandle('adminhtml_sales_order_create_load_block_json');
        } else {
            $update->addHandle('adminhtml_sales_order_create_load_block_plain');
        }

        if ($block) {
            $blocks = explode(',', $block);
            if ($asJson && !in_array('message', $blocks)) {
                $blocks[] = 'message';
            }

            foreach ($blocks as $block) {
                $update->addHandle('adminhtml_sales_order_create_load_block_' . $block);
            }
        }
        $this->loadLayoutUpdates()->generateLayoutXml()->generateLayoutBlocks();
        $result = $this->getLayout()->getBlock('content')->toHtml();
        if ($request->getParam('as_js_varname')) {
            Mage::getSingleton('adminhtml/session')->setUpdateResult($result);
            $this->_redirect('*/*/showUpdateResult');
        } else {
            $this->getResponse()->setBody($result);
        }
    }

    /**
     * Adds configured product to quote
     */
    public function addConfiguredAction()
    {
        $errorMessage = null;
        try {
            $this->_initSession()
                ->_processData();
        }
        catch (Exception $e){
            $this->_reloadQuote();
            $errorMessage = $e->getMessage();
        }

        // Form result for client javascript
        $updateResult = new Varien_Object();
        if ($errorMessage) {
            $updateResult->setError(true);
            $updateResult->setMessage($errorMessage);
        } else {
            $updateResult->setOk(true);
        }

        $updateResult->setJsVarName($this->getRequest()->getParam('as_js_varname'));
        Mage::getSingleton('adminhtml/session')->setCompositeProductResult($updateResult);
        $this->_redirect('*/catalog_product/showUpdateResult');
    }

    /**
     * Start order create action
     */
    public function startAction()
    {
        $this->_getSession()->clear();
        $this->_redirect('*/*', array('customer_id' => $this->getRequest()->getParam('customer_id')));
    }

    /**
     * Cancel order create
     */
    public function cancelAction()
    {
        if ($orderId = $this->_getSession()->getReordered()) {
            $this->_getSession()->clear();
            $this->_redirect('*/sales_order/view', array(
                'order_id'=>$orderId
            ));
        } else {
            $this->_getSession()->clear();
            $this->_redirect('*/*');
        }

    }

    /**
     * Saving quote and create order
     */
    public function saveAction()
    {
        try {
            Mage::getSingleton('admin/session')->setLastInfo($this->getRequest()->getPost());

            $post = $this->getRequest()->getPost();

            $quote = $this->_getOrderCreateModel()->getQuote();
            $quote->setPpmdAffiliate($post['affiliate']);
            $quote->setAffiliateId($post['affiliate']);
            $quote->setPpmdCallReason($post['callReasons']);
            $quote->setLabZip($post['order']['billing_address']['postcode']);
            $quote->setOrderState($post['order']['billing_address']['region_id']);
            $quote->setPpmdRep(Mage::getSingleton('admin/session')->getUser()->getId());
            $quote->getShippingAddress()->setShippingMethod('freeshipping');
            $quote->save();

            $this->_processActionData('save');
            if ($paymentData = $this->getRequest()->getPost('payment')) {
                $this->_getOrderCreateModel()->setPaymentData($paymentData);
                $this->_getOrderCreateModel()->getQuote()->getPayment()->addData($paymentData);
            }

            $order = $this->_getOrderCreateModel()
                ->setIsValidate(true)
                ->importPostData($this->getRequest()->getPost('order'))
                ->createOrder();

			$obj = new Varien_Object();
			$obj->setData($this->getRequest()->getPost());
			
			$ppmdnotify = $this->getRequest()->getPost('newsletter');
			
			$customer = $order->getCustomer();
			
			if ($ppmdnotify == 'yes') {
								
				$customer->setPpmdNotify(1);
								
			}
			
			if ($pres = $this->getRequest()->getPost('prescription')) {
			
				$pres = $this->getRequest()->getPost('prescription');
			
				$pstring = '';
			
				foreach ($pres as $k=>$v) {
				
					$pstring .= "$k, ";
				
				}

				$scriPost = $this->getRequest()->getPost('script');
			
				$script = Mage::getModel('prescriptions/prescriptions');
				$script->setOrderId($order->getId());
				$script->setCustomerId($customer->getId());
				$script->setCustomerName($customer->getFirstname().' '.$customer->getLastname());
				$script->setCustomerPhone($scriPost['cust_num']);
				$script->setPharmacyPhone($scriPost['pharm_num']);
				$script->setAllergies($scriPost['allergies']);
				$script->setCreatedTime('NOW()');
				$script->setCurMeds($scriPost['cur_script_meds']);
				$script->setCurOtcMeds($scriPost['cur_otc_meds']);
				$script->setMedHistory($scriPost['med_history']);			
				$script->setScripts($pstring);
				$script->save();
				
			}

			$affiliate = $this->getRequest()->getPost('affiliate');
			
			$callReason = $this->getRequest()->getPost('callReasons');
			
			$paymentt = $this->getRequest()->getPost('payment');
			
			$ot = $this->getRequest()->getPost('ppmd_order_type');
			
			$order->setOrderType($ot);
			
			$ba = $this->getRequest()->getPost('order');
			
			$preAddress = $ba['billing_address'];
			
			$orderstates = Mage::getModel('directory/country')->loadByCode($ba["billing_address"]["country_id"])
				->getRegions();
				
			foreach ($orderstates as $orderstate) {
				
				if ($orderstate->getRegionId() == $ba["billing_address"]["region_id"]) {
					
					$order->setOrderState($orderstate->getCode()); 
					
				}
				
			}

			if ($ot == 2) {				
			
			$ba["billing_address"]["street"] = implode(" ", $ba["billing_address"]["street"]);
			
			$order->setPpmdLab(serialize($ba["billing_address"]));
			
			} else {
				
				$sArr = Mage::getModel('core/session')->getSerialArr();
				
				$lab = $sArr[$this->getRequest()->getPost('lab-id')];

                if (!$lab || is_null($lab) || $lab == "") {

                    $slab = $this->getRequest()->getPost('serilab');

                    if ($slab != "") {

                        $lab = $slab;

                    }

                }

				$order->setPpmdLab($lab);
								
			}
			
			if ($this->getRequest()->getPost('isnnr')) {
				
				$order->setPpmdProvider(2);
				$order->setFollowUp(7);
				
			} else {
				
				$order->setPpmdProvider(1);
			}
			
			if ($order->getOrderType() == 2) {
		
			$order->setFollowUp(1);
		
		}
			
			$paymethod = $paymentt['method'];
			
			if ($paymethod == 'authorizenet' || $paymethod == 'paylater') {
				
				$order->setPpmdActivate(1);
				
			} else {
				
				$order->setPpmdActivate(0);
			}
			
			
			foreach ($preAddress as $k=>$v) {
				
				if (!is_array($k) && $v == "") {
						
					$v = 'WITHHELD';
				
				} 
				
			}
			
			if ($ba["billing_address"] && is_array(($ba["billing_address"])) && $ba["billing_address"]["street"] && is_array($ba["billing_address"]["street"])) {
			
			foreach ($ba["billing_address"]["street"] as $k=>$v) {
				
				if ($v == "") $v = "WITHHELD";
				
			}
			
			}

			$order->setLabId($this->getRequest()->getPost('lab-id'));
			$order->setLabType($this->getRequest()->getPost('lab-type'));
			$order->setLabZip($this->getRequest()->getPost('lab-zip'));
			$order->setPpmdStatus(0);
			$order->setPpmdAffiliate($affiliate);
			$order->setPpmdCallReason($callReason);
			$order->setPpmdRep(Mage::getSingleton('admin/session')->getUser()->getId());
			
			$pstring = '';
			
			$labRevenue = 0;
		
		foreach($order->getAllItems() as $item) {
		
			$pstring .= $item->getName().",";	
			
			if ($order->getPpmdProvider() != 1) {
			
				$id = Mage::getModel('catalog/product')->getIdBySku($item->getSku());

        		$labRevenue = $labRevenue + Mage::getModel('catalog/product')->load($id)->getPriceOptOne();
						
			}
		
		}

		$pstring = rtrim($pstring,",");
		
		$order->setPstring($pstring);
		
		$order->setLabRevenue($labRevenue);
		
		if (!$order->getIsVirtual()) {
			
			$order->setStatus('complete');
			
		}
					
			$order->save();	
			
			if ($this->getRequest()->getPost('newsletter') == 'yes') {
			
				$customer->setPpmdUpdates(1);
			
			} else {
			
				$customer->setPpmdUpdates(0);
			
			}
			
			$customer->setPpmdNotify($this->getRequest()->getPost('ppmd_notify_type'));
			$customer->setPpmdPhone($ba['billing_address']['telephone']);
			$customer->setGender($ba['account']['gender']);
			//$customer->setDob($this->getRequest()->getPost('m_select').'/'.$this->getRequest()->getPost('d_select').'/'.$this->getRequest()->getPost('y_select'));
			$customer->save();

			$path = Mage::getBaseDir();
			include_once($path.'/lib/PAP/PapApi.class.php');

            $store = Mage::getModel('core/store')->load($order->getStoreId());
            $store_code = $store->getCode();
            /*
             * GetLabTested will not be utilizing PAP moving forward:
             *  Sean Dunagan 3/14/2014
             *
            $pap_credentials = Mage::helper('ppmd_credentials/pap')->getCredentialsByStoreCode($store_code);
            $server_url = $pap_credentials['sale']['url'];

            $saleTracker = new Pap_Api_SaleTracker($server_url);

			$saleTracker->setAccountId($pap_credentials['account_id']);
			$sale2 = $saleTracker->createSale();
			$sale2->setAffiliateId($order->getAffiliateId());
			$sale2->setTotalCost($order->getGrandTotal());
			$sale2->setOrderID($order->getId());
			$sale2->setProductID($order->getPstring());
			$sale2->setStatus("A");

			$saleTracker->register();
            */
			
			Mage::dispatchEvent('checkout_onepage_controller_success_action', array('order_ids' => array($order->getId())));

          	$this->_getSession()->clear();
          	Mage::getSingleton('admin/session')->unsLastInfo();
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The order has been created.'));
            $this->_redirect('*/sales_order/view', array('order_id' => $order->getId()));
        } catch (Mage_Payment_Model_Info_Exception $e) {
            $this->_getOrderCreateModel()->saveQuote();
            $message = $e->getMessage();
            if( !empty($message) ) {
                $this->_getSession()->addError($message);
            }
            $this->_redirect('*/*/');
        } catch (Mage_Core_Exception $e){
            $message = $e->getMessage();
            if( !empty($message) ) {
                $this->_getSession()->addError($message);
            }
            $this->_redirect('*/*/');
        }
        catch (Exception $e){
            $this->_getSession()->addException($e, $this->__('Order saving error: %s', $e->getMessage()));
            $this->_redirect('*/*/');
        }
    }

    /**
     * Acl check for admin
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        $action = strtolower($this->getRequest()->getActionName());
        switch ($action) {
            case 'index':
                $aclResource = 'sales/order/actions/create';
                break;
            case 'reorder':
                $aclResource = 'sales/order/actions/reorder';
                break;
            case 'cancel':
                $aclResource = 'sales/order/actions/cancel';
                break;
            case 'save':
                $aclResource = 'sales/order/actions/edit';
                break;
            default:
                $aclResource = 'sales/order/actions';
                break;
        }
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }

    /*
     * Ajax handler to response configuration fieldset of composite product in order
     *
     * @return Mage_Adminhtml_Sales_Order_CreateController
     */
    public function configureProductToAddAction()
    {
        // Prepare data
        $productId  = (int) $this->getRequest()->getParam('id');

        $configureResult = new Varien_Object();
        $configureResult->setOk(true);
        $configureResult->setProductId($productId);
        $sessionQuote = Mage::getSingleton('adminhtml/session_quote');
        $configureResult->setCurrentStoreId($sessionQuote->getStore()->getId());
        $configureResult->setCurrentCustomerId($sessionQuote->getCustomerId());

        // Render page
        /* @var $helper Mage_Adminhtml_Helper_Catalog_Product_Composite */
        $helper = Mage::helper('adminhtml/catalog_product_composite');
        $helper->renderConfigureResult($this, $configureResult);

        return $this;
    }

    /*
     * Ajax handler to response configuration fieldset of composite product in quote items
     *
     * @return Mage_Adminhtml_Sales_Order_CreateController
     */
    public function configureQuoteItemsAction()
    {
        // Prepare data
        $configureResult = new Varien_Object();
        try {
            $quoteItemId = (int) $this->getRequest()->getParam('id');
            if (!$quoteItemId) {
                Mage::throwException($this->__('Quote item id is not received.'));
            }

            $quoteItem = Mage::getModel('sales/quote_item')->load($quoteItemId);
            if (!$quoteItem->getId()) {
                Mage::throwException($this->__('Quote item is not loaded.'));
            }

            $configureResult->setOk(true);
            $optionCollection = Mage::getModel('sales/quote_item_option')->getCollection()
                    ->addItemFilter(array($quoteItemId));
            $quoteItem->setOptions($optionCollection->getOptionsByItem($quoteItem));

            $configureResult->setBuyRequest($quoteItem->getBuyRequest());
            $configureResult->setCurrentStoreId($quoteItem->getStoreId());
            $configureResult->setProductId($quoteItem->getProductId());
            $sessionQuote = Mage::getSingleton('adminhtml/session_quote');
            $configureResult->setCurrentCustomerId($sessionQuote->getCustomerId());

        } catch (Exception $e) {
            $configureResult->setError(true);
            $configureResult->setMessage($e->getMessage());
        }

        // Render page
        /* @var $helper Mage_Adminhtml_Helper_Catalog_Product_Composite */
        $helper = Mage::helper('adminhtml/catalog_product_composite');
        $helper->renderConfigureResult($this, $configureResult);

        return $this;
    }


    /**
     * Show item update result from loadBlockAction
     * to prevent popup alert with resend data question
     *
     */
    public function showUpdateResultAction()
    {
        $session = Mage::getSingleton('adminhtml/session');
        if ($session->hasUpdateResult() && is_scalar($session->getUpdateResult())){
            $this->getResponse()->setBody($session->getUpdateResult());
            $session->unsUpdateResult();
        } else {
            $session->unsUpdateResult();
            return false;
        }
    }
	
	
	public function getlabsAction()
    {
        	
    	$zipCode = $this->getRequest()->getPost('zip_code');
    	    	
    	Mage::getSingleton('admin/session')->setZip($zipCode);
    	
    	$stateModel = Mage::getModel('pricing/pricing')->getCollection()->addFieldToFilter('zip_code',array('eq'=>$zipCode));
    	
    	$state = $stateModel->getFirstItem()->getState();
    	    	
    	Mage::getSingleton('core/session')->setOrderState($state);

        if (in_array($state,array("NY","NJ","RI"))) {

            Mage::getSingleton('core/session')->setIsNnr(1);

        } else {

            Mage::getSingleton('core/session')->setIsNnr(0);

        }

    	if (Mage::helper('medivo')->isNNRState($state)) {
    		Mage::getSingleton('core/session')->setIsNnr(1);
    	} else {
    		Mage::getSingleton('core/session')->setIsNnr(0);
    	}

    	$this->loadLayout();     
		$this->renderLayout();
    }
	
	 public function lostorderAction()

   {
    
   	$post = $this->getRequest()->getPost();
    
    $quote = Mage::getSingleton('checkout/cart')->getQuote();
        
    //$quote->setData($post);
    
    $quote->setLostOrder(1);
    
    $quote->setPpmdAffiliate($post['affiliate']);

    $quote->setPpmdCallReason($post['callReasons']);
    
    $quote->setLabZip($post['order']['billing_address']['postcode']);
    
    $quote->setOrderState($post['order']['billing_address']['region_id']);

    $quote->setPpmdRep(Mage::getSingleton('admin/session')->getUser()->getId());
    
    
    $quote->save();

        
     return true;

    

  }
	
	
}
