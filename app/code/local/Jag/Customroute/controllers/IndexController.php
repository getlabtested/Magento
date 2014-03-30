<?php
require_once "Mage/Cms/controllers/IndexController.php";

class Jag_Customroute_IndexController extends Mage_Cms_IndexController
{
    protected function _getSession()
    {
        return Mage::getSingleton('checkout/session');
    }
    
    public function noRouteAction($coreRoute = null)
    {
    $url = explode("/",Mage::app()->getRequest()->getRequestString());
           
    array_shift($url);
    
    $str = implode('/',$url);

    $localepage = Mage::getModel('localepage/localepage')->load($str,'url_key');

    if ($localepage->getId() && $localepage->getStatus() == 1) {
               $this->_forward('index','index','localepage',array('localepage'=>$localepage));
        return;
    } else if ($localepage->getId() && $localepage->getStatus() == 2) {
    
        $this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
                    $this->getResponse()->setHeader('Status','404 File not found');
                    $pageId = Mage::getStoreConfig('web/default/cms_no_route');
                    $this->_redirect('custom-404');
    
        return;
    }
    
    $blog = Mage::getModel('blog/blog')->load($str,'identifier');
                                    
    if ($blog->getId()) {
                                        
            $this->_forward('view','post','blog',array('identifier'=>$str));
            
        return;
                    
    }
        
    switch(count($url)) {
            
            case 1:
                        
                $localepage = Mage::getModel('localepage/localepage')->load($url[0],'url_key');
                                                
                if ($localepage->getId()) {
        
                    $this->_forward('index','index','localepage',array('localepage'=>$localepage));
        
                } else {

                    $this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
                    $this->getResponse()->setHeader('Status','404 File not found');
                    $this->_redirect('custom-404');
        
                }
            
            break;
            
            case 2:
                
                if ($url[0] == 'std-test-centers') {
                                                    
                $tmp = explode("-",$url[1]);
                
                if (count($tmp) == 2) {
                
                    $stateFull = $tmp[0];
                    $state = $tmp[1];
                
                }
                
                if (count($tmp) == 3) {
                
                    $stateFull = $tmp[0]." ".$tmp[1];
                    $state = $tmp[2];
                
                }
                
                if (count($tmp) == 4) {
                
                    $stateFull = $tmp[0]." ".$tmp[1]." ".$tmp[2];
                    $state = $tmp[3];
                
                }
                                                                        
                    $this->_forward('dynamic','index','localepage',array(
                        'state'=>$state,
                        'stateFull'=>$stateFull,
                        'template'=>'std_testing_city.phtml'
                        )
                    );    
                                                        
                } else if ($url[0] == 'free-std-clinics') {
                    
                    $tmp = explode("-",$url[1]);
                    
                if (count($tmp) == 2) {
                
                    $stateFull = $tmp[0];
                    $state = $tmp[1];
                
                }
                    
                    if (count($tmp) == 3) {
                
                    $stateFull = $tmp[0]." ".$tmp[1];
                    $state = $tmp[2];
                
                }
                    
                    if (count($tmp) == 4) {
                
                    $stateFull = $tmp[0]." ".$tmp[1]." ".$tmp[2];
                    $state = $tmp[3];
                
                }
                                                                        
                    $this->_forward('dynamicfree','index','localepage',array(
                        'state'=>$state,
                        'stateFull'=>$stateFull,
                        'template'=>'std_testing_city_free.phtml'
                        )
                    );
                                        
                } else {
                    
                    $this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
                    $this->getResponse()->setHeader('Status','404 File not found');
                    $pageId = Mage::getStoreConfig('web/default/cms_no_route');
                    $this->_redirect('custom-404');
                    
                }
                
                                
                            
            break;
        
            case 3:
                                
                if ($url[0] == 'std-test-centers') {
                                            
                $tmpState = explode("-",$url[1]);
                
                if (count($tmpState) == 2) {
                
                    $stateFull = $tmpState[0];
                    $state = $tmpState[1];
                
                }
                
                if (count($tmpState) == 3) {
                
                    $stateFull = $tmpState[0]." ".$tmpState[1];
                    $state = $tmpState[2];
                
                }
                
                if (count($tmpState) == 4) {
                
                    $stateFull = $tmpState[0]." ".$tmpState[1]." ".$tmpState[2];
                    $state = $tmpState[3];
                
                }
                
                $city = str_replace('-',' ',$url[2]);
                                                                        
                    $this->_forward('dynamic','index','localepage',array(
                        'state'=>$state,
                        'stateFull'=>$stateFull,
                        'city'=>$city,
                        'template'=>'std_testing_location.phtml'
                        )
                    );    
                    
                } else if ($url[0] == 'free-std-clinics') {
                    
                $tmpState = explode("-",$url[1]);
                
                if (count($tmpState) == 2) {
                
                    $stateFull = $tmpState[0];
                    $state = $tmpState[1];
                
                }
                
                if (count($tmpState) == 3) {
                
                    $stateFull = $tmpState[0]." ".$tmpState[1];
                    $state = $tmpState[2];
                
                }
                
                if (count($tmpState) == 4) {
                
                    $stateFull = $tmpState[0]." ".$tmpState[1]." ".$tmpState[2];
                    $state = $tmpState[3];
                
                }
                
                $city = str_replace('-',' ',$url[2]);
                                                                        
                    $this->_forward('dynamicfree','index','localepage',array(
                        'state'=>$state,
                        'stateFull'=>$stateFull,
                        'city'=>$city,
                        'template'=>'std_testing_location_free.phtml'
                        )
                    );    
                                        
                } else {
                    
                    
                    $this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
                    $this->getResponse()->setHeader('Status','404 File not found');
                    $pageId = Mage::getStoreConfig('web/default/cms_no_route');
                    $this->_redirect('custom-404');
                    
                    
                }                            
                            
            break;
            
            case 4:
            
                if ($url[0] == 'std-test-centers') {
            
                $tmpState = explode("-",$url[1]);
                
                if (count($tmpState) == 2) {
                
                    $stateFull = $tmpState[0];
                    $state = $tmpState[1];
                
                }
                
                if (count($tmpState) == 3) {
                
                    $stateFull = $tmpState[0]." ".$tmpState[1];
                    $state = $tmpState[2];
                
                }
                
                if (count($tmpState) == 4) {
                
                    $stateFull = $tmpState[0]." ".$tmpState[1]." ".$tmpState[2];
                    $state = $tmpState[3];
                
                }
                
                                
                $city = str_replace('-',' ',$url[2]);
                
                $ldetail = explode('-', $url[3]);
                                                                        
                    $this->_forward('dynamic','index','localepage',array(
                        'state'=>$state,
                        'stateFull'=>$stateFull,
                        'city'=>$city,
                        'dyn_id' => $ldetail[0],
                        'template'=>'std_testing_location_detail.phtml'
                        )
                    );                                    
                
                } else if ($url[0] == 'free-std-clinics') {
                    
                    $tmpState = explode("-",$url[1]);
                    
                    if (count($tmpState) == 2) {
                
                    $stateFull = $tmpState[0];
                    $state = $tmpState[1];
                
                }
                
                if (count($tmpState) == 3) {
                
                    $stateFull = $tmpState[0]." ".$tmpState[1];
                    $state = $tmpState[2];
                
                }
                
                if (count($tmpState) == 4) {
                
                    $stateFull = $tmpState[0]." ".$tmpState[1]." ".$tmpState[2];
                    $state = $tmpState[3];
                
                }
                                
                $city = str_replace('-',' ',$url[2]);
                
                $ldetail = explode('-', $url[3]);
                                                                                        
                    $this->_forward('dynamicfree','index','localepage',array(
                        'state'=>$state,
                        'stateFull'=>$stateFull,
                        'city'=>$city,
                        'dyn_id' => $ldetail[0],
                        'template'=>'std_testing_location_detail_free.phtml'
                        )
                    );    
                    
                } else {
                    
                    
                    $this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
                    $this->getResponse()->setHeader('Status','404 File not found');
                    
                    $pageId = Mage::getStoreConfig('web/default/cms_no_route');
                    $this->_redirect('custom-404');
                    
                }                                        
                            
            break;
        
        
        }

    }
    
    public function checkoutAction()
    {
        $post = Mage::app()->getRequest()->getPost();
        if (!$post || !is_array($post))
        {
            $this->_redirect('checkout/onepage');
            return;
        }

        Mage::getSingleton('core/session')->setHasEarlyDetect(0);
        Mage::getSingleton('customer/session')->setHasEarlyDetect(0);
        Mage::getSingleton('core/session')->setScriptData(null);
        Mage::getSingleton('core/session')->setScript(0);
        $quote = Mage::getSingleton('checkout/session')->getQuote();

        if (!$quote->getId()) {
            $quote = Mage::getModel('checkout/cart')->getQuote();
        }

        if (count($quote->getAllItems()) > 0)
        {
            Mage::helper('customroute')->clearCartIfNeeded($post, $quote);

            $quote->setAppliedRuleIds(0);
            if (!isset($post['script']) || !$post['script']) {
                Mage::getSingleton('core/session')->setScriptData(null);
                Mage::getSingleton('core/session')->setScript(0);
            }
        }

        if (!isset($post['script']) || !$post['script']) {
            $zipCode = Mage::getSingleton('core/session')->getZip();

            if (!$zipCode) {
                $zipCode = Mage::getSingleton('core/session')->getLabZip();
            }

            $state = Mage::getSingleton('core/session')->getOrderState();
            $data = Mage::getSingleton('core/session')->getVisitorData();
            $checkout = Mage::getSingleton('checkout/cart');
            $ids = array();

            if (isset($post['indiTest']) && is_array($post['indiTest']) && count($post['indiTest']) > 0) {
                $ids = array();
                foreach ($post['indiTest'] as $k=>$v) {
                    $id['id'] = Mage::getModel('catalog/product')->getIdBySku($k);
                    $id['sku'] = $k;
                    $ids[] = $id['id'];
                    $skus[] = $id['sku'];
                }
                Mage::getSingleton('core/session')->setOrderType(1);
            }

            if (isset($post['homeTest']) && is_array($post['homeTest']) && count($post['homeTest']) > 0) {
                // If zip code has been set, check for unallowed nnr tests
                if ($zipCode)
                {
                    $state = Mage::helper('medivo')->getStateFromZipCode($zipCode);
                    if (Mage::helper('medivo')->isNNRState($state))
                    {
                        // Check that the user doesn't have any items in cart which are unallowed in nnr states
                        $nnr_unallowed_items = Mage::helper('medivo/labs')->getNnrUnallowedItemsInPostArray(array_keys($post['homeTest']));

                        if (count($nnr_unallowed_items))
                        {
                            $error_message = "Due to state regulations in ".Mage::helper('medivo')->getNnrStatesString().", the following tests are unavailable in your state: ".implode(", ", $nnr_unallowed_items);
                            Mage::getSingleton('core/session')->addError($error_message);
                            $this->_redirect("std-tests",null);
                            return;
                        }
                    }
                }

                $ids = array();
                foreach ($post['homeTest'] as $k=>$v) {

                    if (Mage::getSingleton('core/session')->getIsNnr() && $k != 'hiv-home') {
                        $error_message = "Due to state regulations in ".Mage::helper('medivo')->getNnrStatesString().", the Home STD Testing Kit you've select is not available";
                        Mage::getSingleton('core/session')->addError($error_message);
                        $this->_redirect("std-testing-options",null);
                        return;
                    }
                    $id['id'] = Mage::getModel('catalog/product')->getIdBySku($k);
                    $id['sku'] = $k;
                    $ids[] = $id['id'];
                    $skus[] = $id['sku'];

                }

                Mage::getSingleton('core/session')->setOrderType(2);
                Mage::getSingleton('core/session')->unsLabId();
                Mage::getSingleton('core/session')->unsLabType();
                Mage::getSingleton('core/session')->unsLabCode();
                Mage::getSingleton('core/session')->unsPpmdLab();
                $zipCode = null;
            }

            if (isset($post['package']) && $post['package'] > 0) {

                $ids = array();
                $skus = array();
                $ids[] = $post['package'];
                $sku = Mage::getModel('catalog/product')->load($post['package'])->getSku();
                $skus[] = $sku;

                    if (isset($post['indiTest']) && isset($post['indiTest']['hiv-early-detection-lab'])) {
                        $skus[] = 'hiv-early-detection-lab';
                        $ids[] = Mage::getModel('catalog/product')->getIdBySku('hiv-early-detection-lab');
                        Mage::getSingleton('core/session')->setHasEarlyDetect(1);
                        Mage::getSingleton('customer/session')->setHasEarlyDetect(1);
                    }

                //Mage::getSingleton('checkout/session')->getQuote()->setOrderType(1)->save();
                Mage::getSingleton('core/session')->setOrderType(1);
            }

            $cd = Mage::getSingleton('customer/session')->getCustomer();
            Mage::getSingleton('core/session')->setCd($cd);

            if (Mage::helper('medivo')->isNNRState($state) && (Mage::getSingleton('core/session')->getOrderType() == 1)) {

                $newIds = array();

                Mage::helper('customroute')->convertCartItemsToNNR();

                foreach ($skus as $sku) {
                    $tid = Mage::getModel('catalog/product')->getIdBySku("nnr-".$sku);
                    $newIds[] = $tid;
                }

                if ( ! Mage::helper('medivo')->cartContainsItems(array("nnr-lab-testing")) )
                {
                    $charge = Mage::getModel('catalog/product')->getIdBySku("nnr-lab-testing");
                    $newIds[] = $charge;
                }

                //Mage::getSingleton('core/session')->setCartArr($newIds);
                $this->_addIdsToSessionCartArr($newIds);

                $checkout->addProductsByIds($newIds);
            } else {
                //Mage::getSingleton('core/session')->setCartArr($ids);
                $this->_addIdsToSessionCartArr($ids);
                $checkout->addProductsByIds($ids);
            }

            try {
                $checkout->save();
            } catch (Exception $e) {
                print_r($e->getMessage());
                exit();
            }

            $quote = Mage::getSingleton('checkout/session')->getQuote();
            $quote->setAffiliateId(Mage::getSingleton('core/session')->getAffiliateId());
            $quote->setPpmdAffiliate(Mage::getSingleton('core/session')->getAffiliateId());
            $quote->setOrderState(Mage::getSingleton('core/session')->getOrderState());
            $quote->setIsNnr(Mage::getSingleton('core/session')->getIsNnr());
            $quote->setLabId(Mage::getSingleton('core/session')->getLabId());
            $quote->setLabZip($zipCode);
            $quote->setLabType(Mage::getSingleton('core/session')->getLabType());
            $quote->setLabCode(Mage::getSingleton('core/session')->getLabCode());
            $quote->setPpmdLab(Mage::getSingleton('core/session')->getPpmdLab());
            $quote->setOrderType(Mage::getSingleton('core/session')->getOrderType());
            $quote->setTotalsCollectedFlag(false)->collectTotals()->save();
            $this->_getSession()->setCartWasUpdated(true);
            $this->_redirect('checkout/onepage');
        }
    }
    
    protected function _addIdsToSessionCartArr($new_ids)
    {
        $current_session_cart_arr = Mage::getSingleton('core/session')->getCartArr();
        if (!is_array($current_session_cart_arr) || empty($current_session_cart_arr))
        {
            Mage::getSingleton('core/session')->setCartArr($new_ids);
            return;
        }
        $new_session_cart_arr = array_merge($new_ids, $current_session_cart_arr);
        $new_session_cart_arr = array_unique($new_session_cart_arr);
        Mage::getSingleton('core/session')->setCartArr($new_session_cart_arr);
    }

    public function checkoutmobileAction() {

        $post = Mage::app()->getRequest()->getPost();
        Mage::getSingleton('core/session')->setHasEarlyDetect(0);
        Mage::getSingleton('customer/session')->setHasEarlyDetect(0);
        Mage::getSingleton('core/session')->setScriptData(null);        
        Mage::getSingleton('core/session')->setScript(0);
        
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        
        if ($quote->getId()) {
            $quote = $quote;
        } else {
            $quote = Mage::getModel('checkout/cart')->getQuote();
        }
        
        if (count($quote->getAllItems()) > 0) {

            Mage::helper('customroute')->clearCartIfNeeded($post, $quote);
            $quote->setAppliedRuleIds(0);
            
            if (!isset($post['script']) || !$post['script']) {
                Mage::getSingleton('core/session')->setScriptData(null);
                Mage::getSingleton('core/session')->setScript(0);
            }
        }
                
        $post = Mage::app()->getRequest()->getPost();
        $zipCode = Mage::getSingleton('core/session')->getZip();
        $zipCode = $_SESSION['core']['zip'];

        if (!$zipCode) {
            $zipCode = Mage::getSingleton('core/session')->getLabZip();
            $zipCode = $_SESSION['core']['zip'];
        }

        $state = Mage::getSingleton('core/session')->getOrderState();
        $state = $_SESSION['core']['order_state'];
        $data = Mage::getSingleton('core/session')->getVisitorData();
        $checkout = Mage::getSingleton('checkout/cart');

        $ids = array();
        if (isset($post['indiTest']) && is_array($post['indiTest']) && count($post['indiTest']) > 0)
        {
            $ids = array();
            foreach ($post['indiTest'] as $k=>$v)
            {
                $id['id'] = Mage::getModel('catalog/product')->getIdBySku($k);
                $id['sku'] = $k;
                $ids[] = $id['id'];
                $skus[] = $id['sku'];
            }
            Mage::getSingleton('core/session')->setOrderType(1);
        }

        if (isset($post['package']) && $post['package'] > 0)
        {
            $ids = array();
            $skus = array();
            $ids[] = $post['package'];

            $sku = Mage::getModel('catalog/product')->load($post['package'])->getSku();
            $skus[] = $sku;

                if (isset($post['indiTest']) && isset($post['indiTest']['hiv-early-detection-lab']))
                {
                    $skus[] = 'hiv-early-detection-lab';
                    $ids[] = Mage::getModel('catalog/product')->getIdBySku('hiv-early-detection-lab');

                    Mage::getSingleton('core/session')->setHasEarlyDetect(1);
                    Mage::getSingleton('customer/session')->setHasEarlyDetect(1);
                }
            Mage::getSingleton('core/session')->setOrderType(1);
        }

        Mage::getSingleton('core/session')->setOrderType(1); //fake
        Mage::getSingleton('core/session')->setMobileVersion(4); //fake
        $cd = Mage::getSingleton('customer/session')->getCustomer();
        Mage::getSingleton('core/session')->setCd($cd);

        if (Mage::helper('medivo')->isNNRState($state) && (Mage::getSingleton('core/session')->getOrderType() == 1)) {

            $newIds = array();

            foreach ($skus as $sku) {
                $tid = Mage::getModel('catalog/product')->getIdBySku("nnr-".$sku);
                $newIds[] = $tid;
            }

            if ( ! Mage::helper('medivo')->cartContainsItems(array("nnr-lab-testing")) )
            {
                $charge = Mage::getModel('catalog/product')->getIdBySku("nnr-lab-testing");
                $newIds[] = $charge;
            }

            //Mage::getSingleton('core/session')->setCartArr($newIds);
            $this->_addIdsToSessionCartArr($newIds);
            $checkout->addProductsByIds($newIds);

        } else {
            //Mage::getSingleton('core/session')->setCartArr($ids);
            $this->_addIdsToSessionCartArr($ids);
            $checkout->addProductsByIds($ids);
        }

        try {
            $checkout->save();
        } catch (Exception $e) {
            print_r($e->getMessage()); exit();
        }

        $quote = Mage::getSingleton('checkout/session')->getQuote();

        $quote->setAffiliateId(Mage::getSingleton('core/session')->getAffiliateId());
        $quote->setPpmdAffiliate(Mage::getSingleton('core/session')->getAffiliateId());
        $quote->setOrderState($state);
        $quote->setIsNnr(Mage::getSingleton('core/session')->getIsNnr());
        $quote->setLabId($_SESSION['lab_id']);
        $quote->setLabZip($zipCode);
        $quote->setLabType($_SESSION['lab_type']);
        $quote->setLabCode($_SESSION['lab_id']);
        $quote->setPpmdLab(serialize($_SESSION['core']['labs_by_zip'][$_SESSION['lab_id']]));
        $quote->setOrderType(1);
        $quote->setTotalsCollectedFlag(false)->collectTotals()->save();
        $this->_getSession()->setCartWasUpdated(true);
        $this->_redirect('checkout/onepage');
    }

    public function checkoutscriptAction()
    {
        $post = Mage::app()->getRequest()->getPost();
        Mage::getSingleton('core/session')->setScriptData(null);
        Mage::getSingleton('core/session')->setScript(0);
        
        if ($quote = Mage::getSingleton('checkout/session')->getQuote())
        {
            Mage::helper('customroute')->clearCartIfNeeded($post, $quote);
            $quote->setAppliedRuleIds(0);
            
            if (!isset($post['script']) || !$post['script'])
            {
                Mage::getSingleton('core/session')->setScriptData(null);
                Mage::getSingleton('core/session')->setScript(0);
            }
            
            //$quote->setTotalsCollectedFlag(false)->collectTotals()->save();
            //$this->_getSession()->setCartWasUpdated(true);
        }
        
        if ($post['script'])
        {
            Mage::getSingleton('core/session')->setScriptData($post);
            Mage::getSingleton('core/session')->setScript(1);

            //Mage::getSingleton('core/session')->setCartArr(array(34));
            $this->_addIdsToSessionCartArr(array(34));
            $checkout = Mage::getModel('checkout/cart');
            $prescriptions_helper = Mage::helper('prescriptions');
            $quote = Mage::getSingleton('checkout/session')->getQuote();
            $prescriptions_helper->clearScriptsFromQuote($quote);
            $checkout->addProductsByIds(array(34));

            $checkout->save();

            //$checkout->getQuote()->setProductLine(2)->collectTotals()->save();
            Mage::getSingleton('checkout/session')->getQuote()
                ->setProductLine(2)
                ->setPpmdProvider(4)
                ->collectTotals()
                ->save();

            $this->_getSession()->setCartWasUpdated(true);

            $this->_redirect('checkout/onepage');
        }
    }
     
    public function checkoutrecAction()
    {
        //Mage::getSingleton('core/session')->setCartArr(array(14));
        $this->_addIdsToSessionCartArr(array(14));

        $checkout = Mage::getModel('checkout/cart');
        $checkout->addProductsByIds(array(14));
        $checkout->save();

        Mage::getSingleton('checkout/session')
            ->getQuote()
            ->setOrderType(1)
            ->save();

        $this->_getSession()->setCartWasUpdated(true);
        $this->_redirect('checkout/onepage');
    }
}
