<?php

class Jag_Medivo_Helper_Data extends PPMD_Tests_Helper_Vendors
{
    const NNR_MEDIVO_STATES_CONFIG_PATH = 'medivo/nnr_states/list';
    const NNR_MEDIVO_STATES_PRICING_MESSAGE_CONFIG_PATH = 'medivo/nnr_states/pricing_message';
    const UNALLOWED_MEDIVO_STATES_CONFIG_PATH = 'medivo/unallowed_states/list';
    const UNALLOWED_MEDIVO_STATES_PRICING_MESSAGE_CONFIG_PATH = 'medivo/unallowed_states/pricing_message';
    const LABCORP_ONLY_SKUS = 'medivo/labcorp_only/skus_list';
    const LABCORP_ONLY_WEBSITES = 'medivo/labcorp_only/website_list';

    const NNR_PRODUCT_SKU_REGEX = '/^nnr-(.*)/';
    const NNR_SKU_PREFIX = 'nnr-';
    const NNR_TESTING_SKU = 'nnr-lab-testing';

    protected $_vendor_name = 'medivo';
    protected $_nnrStates = null;
    protected $_unAllowedStates = null;

    public function getQuestIds($items)
    {
        $test_ids = array();
        if (count($items) > 0)
        {
            foreach ($items as $item)
            {
                $product = Mage::getModel('catalog/product')->load($item->getProductId());
                $id = $product->getQuestTestid();
                if ($id)
                    $test_ids[] = $id;
            }
        }
        return $test_ids;
    }

    public function getLabCorpIds($items)
    {
        $test_ids = array();
        if (count($items) > 0)
        {
            foreach ($items as $item)
            {
                $product = Mage::getModel('catalog/product')->load($item->getProductId());
                $id = $product->getLabcorpTestid();
                if ($id)
                    $test_ids[] = $id;
            }
        }
        return $test_ids;
    }
    
    public function getAtHomeIds($items)
    {
        $test_ids = array();
        if (count($items) > 0)
        {
            foreach ($items as $item)
            {
                $product = Mage::getModel('catalog/product')->load($item->getProductId());
                $id = $product->getAthomeTestid();
                if ($id) {
                    $test_ids[] = $id;
                }
            }
        }
        return $test_ids;
    }
    
    public function validZip($zipCode, $zipFunction) {
        $zipValidationLength = 10;
        $zipCodeLength = 5;
        $zip5 = '';
        if($zipCodeLength > strlen($zipCode)) {
            throw new ErrorException('Zip length is to short: ' . $zipCode, 210);
        }
        if(!method_exists(get_class(), $zipFunction)) {
            throw new ErrorException('Zip validation function is not found' . $zipFunction, 220);
        }
        if($zipCodeLength < strlen($zipCode)) {
            $zip5 = substr($zipCode, 0, 5);
        } else {
            $zip5 = $zipCode;
        }
        foreach(self::$zipFunction() as $validation) {
            if($zipValidationLength != strlen($validation)) {
                throw new ErrorException('Incorrect validation length for ' . $zipFunction . ' ' . $validation, 230);
            }
            $start = substr($validation, 0, $zipCodeLength);
            $end = substr($validation, $zipCodeLength,$zipValidationLength);
            if($start <= $zip5 && $end >= $zip5) {
                return true;
            }
        }
        return false;
    }
    
    public function isNNR($zipCode) {
        $stateFunctionList = array('getNYZ', 'getNJZ', 'getRIZ');
        foreach ($stateFunctionList as $zipFunction) {
            try {
                $valid = self::validZip($zipCode, $zipFunction);
                if($valid) {
                    return true;
                }
            } catch (Exception $e) {
                if(210 == $e->getCode()) {
                    return false;
                }
                throw $e;
            }
        }
        return false;
    }

    private function getNYZ() {
        $zipPrefix = array('0630006399', '0050000599', '0900014999');
        return $zipPrefix;
    }

    private function getNJZ() {
        $zips = array('0700007999', '0800008999');
        return $zips;
    }

    private function getRIZ() {
        $zips = array('0280002899', '0290002999');
        return $zips;
    }

    public function selectLab($labid, $labtype)
    {
        $session = Mage::getSingleton('core/session');
        $cart = Mage::getSingleton('checkout/cart');
        $quote = $cart->getQuote();

        $labid = $this->cleanInput($labid);
        $labtype = $this->cleanInput($labtype);

        if (empty($labid) || (!is_numeric($labtype)))
        {
            $session->addError('Please select a lab');
            return false;
        }
        if (empty($labtype) || (!is_numeric($labtype)))
        {
            $session->addError('Please select a lab');
            return false;
        }
        
        $quote->setLabId($labid);
        $quote->setLabType($labtype);
        $quote->save();
        $cart->save();
        Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
        return true;
    }

    public function isStateAllowed($state)
    {
        return !($this->isStateNotAllowed($state) || $this->isNNRState($state));
    }

    public function isNNRState($state)
    {
        if (is_null($this->_nnrStates))
        {
            $nnr_medivo_states_array = Mage::getStoreConfig(self::NNR_MEDIVO_STATES_CONFIG_PATH);
            if (is_array($nnr_medivo_states_array))
            {
                $this->_nnrStates = array_keys($nnr_medivo_states_array);
            }
            else
            {
                $this->_nnrStates = array();
            }
        }
        return in_array($state, $this->_nnrStates);
    }

    public function isStateNotAllowed($state)
    {
        if (is_null($this->_unAllowedStates))
        {
            $this->_unAllowedStates = array_keys(Mage::getStoreConfig(self::UNALLOWED_MEDIVO_STATES_CONFIG_PATH));
        }
        return in_array($state, $this->_unAllowedStates);
    }

    public function getNnrStatesPricingMessage()
    {
        $state_list = $this->getNnrStatesString();

        $state_message = Mage::getStoreConfig(self::NNR_MEDIVO_STATES_PRICING_MESSAGE_CONFIG_PATH);
        return str_replace("{__STATES__}", $state_list, $state_message);
    }

    public function getUnallowedStatesPricingMessage()
    {
        $state_list = $this->getUnallowedStatesString();
        $state_message = Mage::getStoreConfig(self::UNALLOWED_MEDIVO_STATES_PRICING_MESSAGE_CONFIG_PATH);
        return str_replace("{__STATES__}", $state_list, $state_message);
    }

    public function getNnrStatesString()
    {
        $list_of_states = array_keys(Mage::getStoreConfig(self::NNR_MEDIVO_STATES_CONFIG_PATH));

        $last_state = '';
        if (count($list_of_states) > 1)
        {
            $last_state = ', and '.array_pop($list_of_states);
        }
        return implode(", ", $list_of_states).$last_state;
    }

    public function getUnallowedStatesString()
    {
        $list_of_states = array_keys(Mage::getStoreConfig(self::UNALLOWED_MEDIVO_STATES_CONFIG_PATH));

        $last_state = '';
        if (count($list_of_states) > 1)
        {
            $last_state = ', and '.array_pop($list_of_states);
        }
        return implode(", ", $list_of_states).$last_state;
    }

    public function validateLabTestData($post)
    {
        if (!is_array($post))
        {
            return false;
        }

        if (!isset($post['lab-selected']) || empty($post['lab-selected']))
        {
            return false;
        }

        if (!isset($post['lab_id']) || empty($post['lab_id']))
        {
            return false;
        }

        return true;
    }

    public function setLabSpecificSessionData($lab_id)
    {
        try{
            $labsByZip = (array)Mage::getSingleton('core/session')->getLabsByZip();
            if (!is_array($labsByZip) || !count($labsByZip))
            {
                return false;
            }

            $quote = Mage::getSingleton('checkout/session')->getQuote();
            $labType = 0;

            foreach ($labsByZip as $lab) {
                $lab = (array)$lab;
                if (isset($lab['id'])) $tlab = $lab['id'];
                if (isset($lab['nnr_id'])) $tlab = $lab['nnr_id'];
                if ($tlab == $lab_id)
                {
                    $quote->setPpmdLab(serialize($lab));
                    $quote->setLabCode($lab['code']);
                    Mage::getSingleton('core/session')->setLabZip($lab['zip']);
                    Mage::getSingleton('core/session')->setZip(substr($lab['zip'],0,5));
                    Mage::getSingleton('core/session')->setPpmdLab(serialize($lab));
                    Mage::getSingleton('core/session')->setLabCode($lab['code']);

                    $labType = $lab['lab-id'];
                }
            }

            $quote->setLabId($lab_id)
                ->setLabType($labType)
                ->setOrderType(1)
                ->setLabZip(Mage::getSingleton('core/session')->getLabZip())
                ->setOrderState(Mage::getSingleton('core/session')->getOrderState())
                ->save();

            Mage::getSingleton('core/session')->setQuoteId($quote->getId());
            Mage::getSingleton('core/session')->setLabId($lab_id);
            Mage::getSingleton('core/session')->setLabType($labType);

            return true;
        }
        catch(Exception $e)
        {
            Mage::logException($e);
            return false;
        }
        return false;
    }

    public function getSelectLabUrl()
    {
        return Mage::getBaseUrl().'medivo/local/selectlab';
    }

    public function getAtHomeTestsPageUrl()
    {
        return $this->_getUrl('at-home-std-tests');
    }
    
    public function getLabCorpOnlySkus()
    {
        return array_keys(Mage::getStoreConfig(self::LABCORP_ONLY_SKUS));
    }

    public function cartContainsItems($item_skus_to_search_for)
    {
        $found_skus = array();
        $cart_array = Mage::getSingleton('core/session')->getCartArr();

        if (is_array($cart_array))
        {
            foreach ($cart_array as $product_id)
            {
                $product = Mage::getModel('catalog/product')->load($product_id);
                $sku = $product->getSku();

                if (in_array($sku, $item_skus_to_search_for))
                {
                    $found_skus[] = $sku;
                }
            }
        }

        return $found_skus;
    }

    public function postContainsSkus($post_array, $skus_to_search_for)
    {
        $found_skus = array();

        foreach ($post_array as $post_sku)
        {
            if (in_array($post_sku, $skus_to_search_for))
            {
                $found_skus[]= $post_sku;
            }
        }

        return $found_skus;
    }

    public function getStateFromZipCode($zip_code)
    {
        $stateModel = Mage::getModel('pricing/pricing')->getCollection()->addFieldToFilter('zip_code',array('eq'=>$zip_code));
        $state = $stateModel->getFirstItem()->getState();
        return $state;
    }

    public function convertCartProductsToNormal()
    {
        try
        {
            $quote = Mage::helper('checkout/cart')->getQuote();
            $quote_items = $quote->getItemsCollection();

            foreach($quote_items->getItems() as $item)
            {
                $product = Mage::getModel('catalog/product')->load($item->getProductId());

                $nnr_testing_sku = self::NNR_TESTING_SKU;
                $sku = $product->getSku();

                if (strcmp($sku, $nnr_testing_sku) === 0)
                {
                    $quote->removeItem($item->getItemId());
                    $item->isDeleted(true);
                    $item->save();

                    continue;
                }

                if ($this->isNnrProduct($product))
                {
                    $normal_product = $this->getNormalProductAnalog($product);
                    $quote->addProduct($normal_product);

                    $quote->removeItem($item->getItemId());
                    $item->isDeleted(true);
                    $item->save();
                }
            }

            $quote->save();
        }
        catch(Exception $e)
        {
            Mage::log('Error occurred while trying to convert quote items to normal items');
            Mage::log($e->getMessage());
        }

        return;
    }

    public function convertCartProductsToNnr()
    {
        try
        {
            $quote = Mage::helper('checkout/cart')->getQuote();
            $quote_items = $quote->getItemsCollection();

            $nnr_testing_product_is_in_cart = false;
            $nnr_testing_sku = self::NNR_TESTING_SKU;

            foreach($quote_items->getItems() as $key => $item)
            {
                $product = Mage::getModel('catalog/product')->load($item->getProductId());
                $sku = $product->getSku();

                if (strcmp($sku, $nnr_testing_sku) === 0)
                {
                    $nnr_testing_product_is_in_cart = true;
                }

                if (!$this->isNnrProduct($product))
                {
                    $nnr_product = $this->getNnrProductAnalog($product);
                    $quote->addProduct($nnr_product);

                    $quote->removeItem($item->getItemId());
                    $item->isDeleted(true);
                    $item->save();
                }
            }

            // Check to make sure that nnr-testing-cart product is in the quote
            if (!$nnr_testing_product_is_in_cart)
            {
                $nnr_testing_product_id = Mage::getModel('catalog/product')->getIdBySku($nnr_testing_sku);
                $nnr_testing_product = Mage::getModel('catalog/product')->load($nnr_testing_product_id);
                $quote->addProduct($nnr_testing_product);
            }

            $quote->save();
        }
        catch(Exception $e)
        {
            Mage::log('Error occurred while trying to convert quote items to nnr items');
            Mage::log($e->getMessage());
        }
        return;
    }

    public function getNormalProductAnalog($nnr_product)
    {
        try
        {
            $sku = $nnr_product->getSku();
            $pattern = self::NNR_PRODUCT_SKU_REGEX;

            $matches = array();
            $result = preg_match($pattern, $sku, $matches);

            if ($result)
            {
                $normal_product_sku = $matches[1];
                $normal_product_id = Mage::getModel('catalog/product')->getIdBySku($normal_product_sku);

                if (!$normal_product_id)
                {
                    throw new Exception("No product was found with sku ".$normal_product_sku);
                }
            }
            $normal_product = Mage::getModel('catalog/product')->load($normal_product_id);
            return $normal_product;
        }
        catch(Exception $e)
        {
            Mage::log("Error occurred while trying to fetch normal analog of product ".$sku);
            Mage::log($e->getMessage());
            return $nnr_product;
        }

        return $normal_product;
    }

    public function isNnrProduct($product)
    {
        $sku = $product->getSku();
        $pattern = self::NNR_PRODUCT_SKU_REGEX;

        return preg_match($pattern, $sku);
    }

    public function getNnrProductAnalog($product)
    {
        try
        {
            $sku = $product->getSku();
            $nnr_sku = self::NNR_SKU_PREFIX.$sku;
            $nnr_product_id = Mage::getModel('catalog/product')->getIdBySku($nnr_sku);

            if (!$nnr_product_id)
            {
                throw new Exception("No product was found with sku ".$nnr_sku);
            }

            $nnr_product = Mage::getModel('catalog/product')->load($nnr_product_id);

            return $nnr_product;
        }
        catch(Exception $e)
        {
            Mage::log("Error occurred while trying to fetch Nnr analog of product ".$sku);
            Mage::log($e->getMessage());
            return $product;
        }

        return $product;
    }

    public function getLabcorpOnlyWebsites()
    {
        $labcorp_only_websites_config_value = Mage::getStoreConfig(self::LABCORP_ONLY_WEBSITES);

        if (!is_array($labcorp_only_websites_config_value)){
            return false;
        }

        return array_keys($labcorp_only_websites_config_value);
    }

    public function currentWebsiteIsLabcorpOnly()
    {
        $labcorp_only_websites = $this->getLabcorpOnlyWebsites();

        if (!is_array($labcorp_only_websites))
        {
            return false;
        }

        $current_website = Mage::app()->getWebsite();
        $current_website_code = $current_website->getCode();

        return in_array($current_website_code, $labcorp_only_websites);
    }

    public function sendVendorEmails($email_type, $order, $customer, $new_randomly_generated_password)
    {
        $template = Mage::getModel('core/email_template');
        $baseDir = Mage::getBaseDir();
        // PAID NOW, LAB TEST, 47 STATES
        if ($order->getPpmdActivate() && $order->getOrderType() == 1 && $order->getPpmdProvider() == 1 && $order->getProductLine() != 2) {
            if (!file_exists($baseDir.'/req/'.$order->getIncrementId().'.pdf')) {
                Mage::getModel('medivo/medivo')->pullReq($order->getId());
            }
            $attachment = $template->getMail()->createAttachment(file_get_contents($baseDir.'/req/'.$order->getIncrementId().'.pdf'));
            $attachment->filename = 'RequisitionFile.pdf';

            if (!Mage::helper('sendmail')->isNonInstructionsEmailStore($order->getStoreId()))
            {
                if ($order->getLabType() == 129) {
                    $attachmentTwo= $template->getMail()->createAttachment(file_get_contents($baseDir.'/ins/LabCorp-Instructions.pdf'));
                    $attachmentTwo->filename = 'LabCorp-Instructions.pdf';
                } else {
                    $attachmentTwo= $template->getMail()->createAttachment(file_get_contents($baseDir.'/ins/QuestLab-Instructions.pdf'));
                    $attachmentTwo->filename = 'QuestLab-Instructions.pdf';
                }
            }
            $template->getMail()->setSubject('PPMD Order Confirmation');
            $email_template_code = Mage::helper('sendmail')->getEmailTemplateByStoreId('order_confirmation', $order->getStoreId());
            $template->sendTransactional($email_template_code,'general',$customer->getEmail(),$customer->getFirstname().' '.$customer->getLastname(),array('order'=>$order,'customer'=>$customer,'pass'=> $new_randomly_generated_password));
        }
        // PAID NOW, HOME TEST, 47 STATES
        if ($order->getPpmdActivate() && $order->getOrderType() == 2 && $order->getPpmdProvider() == 1 && $order->getProductLine() != 2) {
            $template->getMail()->setSubject('PPMD Order Confirmation');
            $template->sendTransactional('ppmd_order_confirmation_home','general',$customer->getEmail(),$customer->getFirstname().' '.$customer->getLastname(),array('order'=>$order,'customer'=>$customer,'pass'=>$new_randomly_generated_password));
        }
        // PAID NOW, HOME TEST, NNR (HIV)
        if ($order->getPpmdActivate() && $order->getOrderType() == 2 && $order->getPpmdProvider() != 1 && $order->getProductLine() != 2) {
            $template->getMail()->setSubject('PPMD Order Confirmation');
            $template->sendTransactional('ppmd_order_confirmation_home_nnr','general',$customer->getEmail(),$customer->getFirstname().' '.$customer->getLastname(),array('order'=>$order,'customer'=>$customer));
        }
        // PAID CASH, LAB TEST, 47 STATES, NOT ACTIVE
        if ($order->getPpmdActivate() == 0 && $order->getOrderType() == 1 && $order->getProductLine() != 2) {
            $inc = $order->getId()*1488;
            $template->getMail()->setSubject('PPMD Order Activation');
            $template->sendTransactional('ppmd_order_activation_pwc','general',$customer->getEmail(),$customer->getFirstname().' '.$customer->getLastname(),array('order'=>$order,'customer'=>$customer,'inc'=>$inc));
        }
        // PRESCRIPTION PLACED
        if ($order->getProductLine() == 2) {
            $template->getMail()->setSubject('PPMD Prescription Order Placed');
            $template->sendTransactional('ppmd_prescription_conf','general',$customer->getEmail(),$customer->getFirstname().' '.$customer->getLastname(),array('customer'=>$customer));
        }
    }
}
