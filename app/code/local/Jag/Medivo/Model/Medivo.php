<?php

class Jag_Medivo_Model_Medivo extends Mage_Core_Model_Abstract
{
    const UNALLOWED_LABS_STATES_CONFIG = 'medivo/lab_lookups/unallowed_states';

    const FULL_ZIP_CODE_PREG = '/([0-9]{5})-[0-9]{4}/';

    protected static $_transport_object = null;

    public function _construct()
    {
        parent::_construct();
        $this->_init('medivo/medivo');
    }
    
    public function createCustomer($order, $notest = 0)
    {
        $baseDir = Mage::getBaseDir();
        $address = $order->getBillingAddress();
        
        if (!Mage::helper('medivo')->isStateAllowed($order->getOrderState()))
        {
            return 0; // Not allowed to talk to Medivo for certain states on any tests
        }
        
        $customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
        $medivo_virtual_products = Mage::helper('ppmd_tests/vendors')->getVirtualProductsByVendorCode($order->getItemsCollection(), 'medivo');

        $labtest = !empty($medivo_virtual_products);
        $test_ids = $this->getTestIds($order, $labtest);

        $street = $address->getStreet();
        $reg_id = $address->getRegionId();
        $region = Mage::getModel('directory/region')->load($reg_id);
        
        $xml = new SimpleXMLElement('<customer/>');
        $lab_is_labcorp = ($order->getLabType() == Mage::helper('medivo/labs')->getLabcorpLabId());
        if ($lab_is_labcorp)
        {
            $acctNum = 12004405;
            //$xml->addChild('account_number', 12004405);
            $xml->addChild('draw_location', 'PSC');
            $xml->addChild('psc', $order->getLabId());
        }
        else if ($order->getLabType() == Mage::helper('medivo/labs')->getQuestLabId())
        {
            $acctNum = 97508147;
            //$xml->addChild('account_number', 97508147);
            $xml->addChild('draw_location', 'PSC');
            $xml->addChild('psc', $order->getLabId());
            $xml->addChild('privacy_id', 'dtc ' . $order->getIncrementId());
        }
        else if ($order->getOrderType() == 2)
        {
            $acctNum = 22675327;
            //$xml->addChild('account_number', 22675327);
            $xml->addChild('draw_location', 'PSC');
            $xml->addChild('privacy_id', 'dtc ' . $order->getIncrementId());
        }

        if (strlen($order->getLabZip()) > 0) {
            $zip = $order->getLabZip();
        } else {
            $zip = $address->getPostcode();
        }
        
        $hasTrich = stripos($test_ids, '19550');
        
        if ($customer->getGender() == 1) {
            $test_ids = str_replace("19550","90801",$test_ids);
        }

        if (!$acctNum || strlen($acctNum) < 5) {
            $oid = $order->getIncrementId();
            mail("ljrweb@gmail.com","POTENTIAL NO REQ MISSING ACCOUNT","$oid labtest: $labtest START: ".print_r($_SERVER,true));
        }
        if (!$test_ids || strlen($test_ids) < 3) {
            $oid = $order->getIncrementId();
            mail("ljrweb@gmail.com","POTENTIAL NO REQ MISSING TEST","$oid labtest: $labtest START: ".print_r($_SERVER,true));
        }

        $xml->addChild('account_number', $acctNum);
        $xml->addChild('validation_version', '2');
        $xml->addChild('first_name', $customer->getFirstname());
        $xml->addChild('last_name', $customer->getLastname());
        $xml->addChild('gender', ($customer->getGender() == 2 ? 'Female' : 'Male'));
        $xml->addChild('dob', $customer->getDob());
        $xml->addChild('state', $region->getCode());
        $xml->addChild('test_types', rtrim($test_ids,","));

        $address_street = $address->getStreet();
        $address_street_is_set = !empty($address_street);
        $address_city = $address->getCity();
        $address_city_is_set = !empty($address_city);

        if ($lab_is_labcorp && $address_street_is_set && $address_city_is_set)
        {
            if (is_array($address_street))
            {
                $address_street = implode("\n", $address_street);
            }
            $xml->addChild('address', $address_street);
            $xml->addChild('city', $address_city);
        }
        else
        {
            $xml->addChild('address', 'WITHHELD');
            $xml->addChild('city', 'WITHHELD');
        }

        $xml->addChild('zip', $zip);
        $xml->addChild('email', $customer->getEmail());
        $xml->addChild('home_phone', 8888888888);
        
        $xml->addChild('take_tests_same_day', 'true');
       
        // Record the post which will be written
        $h=fopen($baseDir.'/req/'.$order->getIncrementId().'-post.txt',"w+");
        fwrite($h, print_r($xml->asXML(),true));
        fclose($h);

        $this->repeatPostToMedivo($xml, $order, $baseDir);

        $eightArr[] = 'Chlamydia';
        $eightArr[] = 'Gonorrhea';
        $eightArr[] = 'Hepatitis B';
        $eightArr[] = 'Hepatitis C';
        $eightArr[] = 'Oral Herpes';
        $eightArr[] = 'Genital Herpes';
        $eightArr[] = 'HIV';
        $eightArr[] = 'Syphilis';
                
        $fourArr[] = 'Chlamydia';
        $fourArr[] = 'Genital Herpes';
        $fourArr[] = 'Gonorrhea';
        $fourArr[] = 'HIV';
        
        $ohghArr[] = 'Oral Herpes';
        $ohghArr[] = 'Genital Herpes';
        
        $cgArr[] = 'Chlamydia';
        $cgArr[] = 'Gonorrhea';

        if ($notest == 0) {
            foreach ($order->getAllItems() as $item) {
                if ($item->getProductId() == 14 || $item->getProductId() == 38) {
                    foreach ($eightArr as $name) {
                        $test = Mage::getModel('tests/tests');
                        $test->setOrderId($order->getId());
                        $test->setCustomerId($order->getCustomerId());
                        $test->setTestName($name);
                        $test->setResult(0);
                        $test->save();
                    }
                } else if ($item->getProductId() == 15 || $item->getProductId() == 37) {
                    foreach ($fourArr as $name) {
                        $test = Mage::getModel('tests/tests');
                        $test->setOrderId($order->getId());
                        $test->setCustomerId($order->getCustomerId());
                        $test->setTestName($name);
                        $test->setResult(0);
                        $test->save();
                    }
                } else if ($item->getProductId() == 40 || $item->getProductId() == 41 || $item->getProductId() == 44) {
                    foreach ($cgArr as $name) {
                        $test = Mage::getModel('tests/tests');
                        $test->setOrderId($order->getId());
                        $test->setCustomerId($order->getCustomerId());
                        $test->setTestName($name);
                        $test->setResult(0);
                        $test->save();
                    }
                } else if ($item->getProductId() == 42 || $item->getProductId() == 43) {
                    foreach ($ohghArr as $name) {
                        $test = Mage::getModel('tests/tests');
                        $test->setOrderId($order->getId());
                        $test->setCustomerId($order->getCustomerId());
                        $test->setTestName($name);
                        $test->setResult(0);
                        $test->save();
                    }
                } else {
                    $test = Mage::getModel('tests/tests');
                    $test->setOrderId($order->getId());
                    $test->setCustomerId($order->getCustomerId());
                    $test->setTestName($item->getName());
                    $test->setResult(0);
                    $test->save();
                }
            }
        }
        return true;
    }

    public function repeatPostToMedivo($xml, $order, $baseDir)
    {
        $result = false;
        for ($attempts = 0; !$result && ($attempts < 1); $attempts++)
        {
            $result = $this->postDataToMedivo($xml, $order, $baseDir);
        }
    }

    public function postDataToMedivo($xml, $order, $baseDir)
    {
        $url = 'https://api16.medivo.com/customers';
        //$url = 'https://api16-staging.medivo.com/customers';

        // Post the xml
        $response = $this->postXml($url,$xml->asXML());
        $xmlobj = simplexml_load_string($response);

        $h=fopen($baseDir.'/req/'.$order->getIncrementId().'-response.txt',"w+");
        fwrite($h, print_r($xmlobj,true));
        fclose($h);

        $url = 'https://api16.medivo.com/customers/'.$xmlobj->id.'?include=requisition';
        //$url = 'https://api16-staging.medivo.com/customers/'.$xmlobj->id.'?include=requisition';
        $reqResponse = $this->_callWs($url);

        $recXml = simplexml_load_string($reqResponse);

        $baseDir = Mage::getBaseDir();

        $h=fopen($baseDir.'/req/'.$order->getIncrementId().'-rec.txt',"w+");
        fwrite($h, print_r($recXml,true));
        fclose($h);

        $h=fopen($baseDir.'/req/'.$order->getIncrementId().'.pdf',"w+");
        fwrite($h, base64_decode($recXml->{'sameday_requisition'}));
        fclose($h);

        $order->setPpmdCustId($xmlobj->id);
        $order->setPpmdCustAcct($xmlobj->{'account_number'});
        $order->setPpmdCustConf($xmlobj->{'confirmation_code'});
        $order->save();

        $req = base64_decode($recXml->{'sameday_requisition'});

        if (strlen($req) == 0)
        {
            return false;
        }
        return true;
    }

    public function customerResults($orderId)
    {
        $order = Mage::getModel('sales/order')->load($orderId);
        
        $medId = $order->getPpmdCustId();
        
        //$url = 'https://api16-staging.medivo.com/customers/'.$xmlobj->id.'?include=requisition';
        $url = 'https://api16.medivo.com/customers/'.$medId.'?include=reconciled_results';
        
        $reqResponse = $this->_callWs($url);
        
        $recXml = simplexml_load_string($reqResponse);    
        
        $baseDir = Mage::getBaseDir();
        
        $h=fopen($baseDir.'/res/test.txt',"w+");
        fwrite($h, print_r($recXml->{'reconciled_results'},true));
        fclose($h);

        //$h=fopen($baseDir.'/res/'.$xmlobj->{'account_number'}.'-'.$xmlobj->{'confirmation_code'}.'.pdf',"w+");
        $h=fopen($baseDir.'/res/'.$order->getIncrementId().'.pdf',"w+");
        fwrite($h, base64_decode($recXml->{'reconciled_results'}->{'results-pdf'}));
        fclose($h);

        return 'res/'.$order->getIncrementId().'.pdf';
    }
    
    public function orderComment($orderId = null,$notes = null,$type = null)
    {
        $baseDir = Mage::getBaseDir();
        $order = Mage::getModel('sales/order')->load($orderId);
        $medId = $order->getPpmdCustId();

        $xml = new SimpleXMLElement('<contact_log/>');
        $xml->addChild('notes', $notes);
        $xml->addChild('type', $type);
        
        $h=fopen($baseDir.'/var/log/'.$medId.'-post.txt',"w+");
        fwrite($h, print_r($xml->asXML(),true));
        fclose($h);

        $url = 'https://api16.medivo.com/customers/'.$medId.'/contact_logs.xml';
        $response = $this->postXml($url,$xml->asXML());
        $xmlobj = simplexml_load_string($response);

        $h=fopen($baseDir.'/var/log/'.$medId.'-response.txt',"w+");
        fwrite($h,$url);
        fwrite($h, print_r($xmlobj,true));
        fclose($h);
        
        return;
    }
    
    public function pullRes($orderId)
    {
        $order = Mage::getModel('sales/order')->load($orderId);
        $medId = $order->getPpmdCustId();
        $url = 'https://api16.medivo.com/customers/'.$medId.'?include=reconciled_results';
        //$url = 'https://api16-staging.medivo.com/customers/'.$medId.'?include=reconciled_results';

        $reqResponse = $this->_callWs($url);
        $recXml = simplexml_load_string($reqResponse);
        $baseDir = Mage::getBaseDir();

        //$h=fopen($baseDir.'/res/'.$xmlobj->{'account_number'}.'-'.$xmlobj->{'confirmation_code'}.'.pdf',"w+");
        $h=fopen($baseDir.'/res/'.$order->getIncrementId().'.pdf',"w+");

        fwrite($h, base64_decode($recXml->{'reconciled_results'}->{'results-pdf'}));
        fclose($h);

        return true;
    }

    public function pullReq($orderId)
    {
        $order = Mage::getModel('sales/order')->load($orderId);
        $medId = $order->getPpmdCustId();
        $url = 'https://api16.medivo.com/customers/'.$medId.'?include=requisition';
        //$url = 'https://api16-staging.medivo.com/customers/'.$medId.'?include=reconciled_results';

        $reqResponse = $this->_callWs($url);
        $recXml = simplexml_load_string($reqResponse);
        $baseDir = Mage::getBaseDir();

        //$h=fopen($baseDir.'/res/'.$xmlobj->{'account_number'}.'-'.$xmlobj->{'confirmation_code'}.'.pdf',"w+");
        $h=fopen($baseDir.'/req/'.$order->getIncrementId().'.pdf',"w+");
        fwrite($h, base64_decode($recXml->{'sameday_requisition'}));
        fclose($h);

        return true;
    }
    
    public function getTestIds($order, $atlab = true)
    {
        $helper = Mage::helper('medivo');
        $labs_helper = Mage::helper('medivo/labs');
        $test_ids = '';

        $medivo_items = Mage::helper('ppmd_tests/vendors')
                                ->getSpecificVendorProducts($order->getItemsCollection(), 'medivo', true);

        if ($atlab){
            switch ($order->getLabType())
            {
                case $labs_helper->getQuestLabId(): // Quest
                    $test_ids = $helper->getQuestIds($medivo_items);
                    break;
                case $labs_helper->getLabcorpLabId(): // LabCorp
                    $test_ids = $helper->getLabCorpIds($medivo_items);
                    break;
                default: // At Home
                    $test_ids = $helper->getAtHomeIds($medivo_items);
                    $atlab = false;
                    break;
            }
        }
        else
        {
            $test_ids = $helper->getAtHomeIds($medivo_items);
        }

        $this->has_tests = (count($test_ids) > 0);

        if (in_array('PP101', $test_ids))
        {
            unset($test_ids['PP101']);
        }

        if ($order->getLabType() == $labs_helper->getLabcorpLabId() && in_array('188078', $test_ids) || in_array('188086', $test_ids))
        {
            unset($test_ids['188078']); // Chlamydia
            unset($test_ids['188086']); // Gonorrhea
            $test_ids[] = 183194;
        }

        if ($order->getLabType() == $labs_helper->getQuestLabId() && in_array('188078', $test_ids) || in_array('188086', $test_ids) && count($test_ids) == 8)
        {
            unset($test_ids['17303']); // Chlamydia
            unset($test_ids['17304']); // Gonorrhea
            $test_ids[] = 17305;
        }

        /*
if ($order->getLabType() == 129 && count($test_ids) == 2 && (in_array(164897,$test_ids) && in_array(163147,$test_ids))) {
            
            $test_ids = array();
            $test_ids[] = 163014;
            
        }
if ($order->getLabType() == 129 && count($test_ids) == 4 && (in_array('083824',$test_ids) && in_array(188078,$test_ids) && in_array(188086,$test_ids) && in_array(163147,$test_ids))) {
            
            $test_ids = array();
            $test_ids[] = 36126;
            
        }
*/
        // BAD CODE
        if ($order->getLabType() == $labs_helper->getLabcorpLabId() && count(explode(",",$test_ids[0])) == 8)
        {
            $origTestIds = $test_ids;
            $test_ids = array();
            $test_ids[] = 343575;
            if (in_array(162100,$origTestIds))
            {
                $test_ids[] = 162100;
            }
        }

        return implode(',', $test_ids);
    }
    
    public function getLabsByZip($zipcode, $output=false, $radius = 100)
    {
        // If zip code is of the form 12345-6789, convert to 12345
        $zip_is_full_form = preg_match(self::FULL_ZIP_CODE_PREG, $zipcode, $matches);

        if ($zip_is_full_form && isset($matches[1]) && $matches[1])
        {
            $zipcode = $matches[1];
        }

        $url = 'https://api16.medivo.com/find_psc/'.$zipcode;
        $response = $this->_callWs($url);
        $response = simplexml_load_string($response);
        $labsArrTmp = $this->simplexml2array($response);
        $pscs = $labsArrTmp['patient-service-center'];

        for ($i = 0; $i <= count($pscs)-1; $i++) {
                if (!isset($pscs->{'active'})) {
                    $obj = $pscs[$i];
                } else {
                    $obj = $pscs;
                }

                $id = (int)$obj->{'id'};
                if (count($obj) < 1) {
                    return "We apologize - it appears your zip code is invalid or there are no testing locations within 100 miles.  Call 866-749-6269 and we'll help determine the best private option for testing.  Alternately, click 'ORDER NOW' to order at home STD testing.";
                }
                foreach ($obj as $k=>$v) {
                    $labsArr[$id][(string)$k] = (string)$v;
                }
        }

        // Remove any labs located in states on the unallowed list
        $unallowed_states_list = array_keys(Mage::getStoreConfig(self::UNALLOWED_LABS_STATES_CONFIG));
        $labsArr = Mage::helper('medivo/labs')->removeLabsInStates($labsArr, $unallowed_states_list);

        // Check to see if Labcorp only products are in the cart
        $labsArr = $this->checkLabcorpOnlyProducts($labsArr);

        self::$_transport_object = new Varien_Object();
        self::$_transport_object->setLabsArray($labsArr);
        Mage::dispatchEvent(
            'exclude_appropriate_labs', array('transport_object' => self::$_transport_object, 'zipcode' => $zipcode)
        );
        $labsArr = self::$_transport_object->getLabsArray();
        Mage::getSingleton('core/session')->setLabsByZip((array)$labsArr);

        if ($output) {
            return $response;
        }
        else {
            return $labsArr;
        }
    }

    public function checkLabcorpOnlyProducts($labs_array)
    {
        $labcorp_only_skus = Mage::helper('medivo')->getLabCorpOnlySkus();
        $labcorp_only_skus_in_cart =
            Mage::helper('medivo')->cartContainsItems($labcorp_only_skus);

        // If this is a post from the admin, we need to check to see if product_ids were passed in
        $product_ids_post = Mage::app()->getRequest()->getPost('product_ids');
        $lab_corp_skus_in_post = false;
        if ($product_ids_post)
        {
            $product_ids = explode(",", $product_ids_post);

            if (is_array($product_ids))
            {
                // Pop off the empty value at end of array
                $dummy_value = array_pop($product_ids);

                foreach ($product_ids as $id)
                {
                    $product = Mage::getModel('catalog/product')->load($id);
                    $sku = $product->getSku();
                    if (in_array($sku, $labcorp_only_skus))
                    {
                        $lab_corp_skus_in_post = true;
                        break;
                    }
                }
            }
        }

        $labcorp_only_skus_are_being_ordered = count($labcorp_only_skus_in_cart) || $lab_corp_skus_in_post;
        // Certain websites (e.g. GLT) should only return Labcorp locations
        $current_website_is_labcorp_only = Mage::helper('medivo')->currentWebsiteIsLabcorpOnly();

        if ($labcorp_only_skus_are_being_ordered || $current_website_is_labcorp_only)
        {
            $labs_array =
                Mage::helper('medivo/labs')->keepOnlyCertainLabType($labs_array, Mage::helper('medivo/labs')->getLabcorpLabId());
        }

        return $labs_array;
    }

    public function getDbLabsByZip($zipcode, $output=true, $radius = 100)
    {
        try {
        $config  = Mage::getConfig()->getResourceConnectionConfig("default_setup");
        $db = new PDO ('mysql:dbname='.$config->dbname.';host='.$config->host, $config->username, $config->password);
        //$config  = Mage::getConfig()->getResourceConnectionConfig("default_setup");
        //$db = new PDO ('mysql:dbname=mag;host=localhost', 'root', '');
        $query = 'Call GetNearbyZipCodes('.$zipcode.', :radius)';            
        $sth = $db->prepare($query);
        $sth->execute(array(':radius' => (float) 100));
        } catch(Exception $e) {
            print_r($e->getMessage());
        }

        $labObjs = array();
        $x = 0;

        $labs_helper = Mage::helper('medivo/labs');
        $labcorp_lab_id = $labs_helper->getLabcorpLabId();
        $current_website_is_labcorp_only = Mage::helper('medivo')->currentWebsiteIsLabcorpOnly();

        while ($labObj = $sth->fetchObject()) {
           if($x < 6) {
               $lab_array = $this->object_to_array($labObj);

               if (!isset($lab_array['lab-id']))
               {
                   continue;
               }
               $lab_id = $lab_array['lab-id'];

               if ($current_website_is_labcorp_only && ($lab_id != $labcorp_lab_id))
               {
                   continue;
               }

               $labObjs[$lab_array['nnr_id']] = $lab_array;
           }
           $x++;
        }

        Mage::getSingleton('core/session')->setLabsByZip($labObjs);
        if ($output) {
            return $labObjs;
        }
        else {
            return;
        }
    }

    function object_to_array($object) {
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                $array[$key] = $value;
            }
        }
        else {
            $array = $object;
        }
        return $array;
    }
    
    function simplexml2array($xml)
    {
        if (is_array($xml)) {
            if (count($xml) == 0) return (string) $xml; // for CDATA
            foreach($xml as $key=>$value) {
                $r[$key] = $this->simplexml2array($value);
            }
            if (isset($a)) $r['@attributes'] = $a;    // Attributes
            return $r;
        }

        if (get_class($xml) == 'SimpleXMLElement') {
            $attributes = $xml->attributes();
            foreach($attributes as $k=>$v) {
                if ($v) $a[$k] = (string) $v;
            }
            $x = $xml;
            $xml = get_object_vars($xml);
        }
        return (array) $xml;
    }
    
    private function _callWs($url)
    {
        //Ask for data in XML format
        $headers[] = "Accept: application/xml";
        $headers[] = "Content-Type: application/xml";

        $ch = curl_init();
        if (false === $ch) {
            throw new ErrorException('Curl had trouble initializing.');
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, 'getstdtest'.':'.'pwn');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);
        if (false === $response) {
            Mage::Log("ERROR $url"); 
            //throw new ErrorException('Could not retrieve information from :'
            //. $url);
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode > 202) { //HTTP error code 200 anything else is a problem
            //Mage::Log($response); 
           //throw new ErrorException('Request returned and error: HTTP-'
           // . $httpCode . "-" . $url);
        }
        return $response;
    }

    private function postXml($url,$xml)
    {
        //Ask for data in XML format
        $headers[] = "Accept: application/xml";
        $headers[] = "Content-Type: application/xml";

        $ch = curl_init();
        if (false === $ch) {
            throw new ErrorException('Curl had trouble initializing.');
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, 'getstdtest'.':'.'pwn');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

        $response = curl_exec($ch);
        if (false === $response) {
            Mage::Log("ERROR $url"); 
            //throw new ErrorException('Could not retrieve information from :'
            //. $url);
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode > 202) { //HTTP error code 200 anything else is a problem
            Mage::Log($response); 
           //throw new ErrorException('Request returned and error: HTTP-'
           // . $httpCode . "-" . $url);
        }
        return $response;
    }
}
