<?php
ini_set("memory_limit","-1"); ini_set('auto_detect_line_endings', true);
ini_set("display_errors",1);
date_default_timezone_set('America/Los_Angeles');

$storeId = 2;

require '../app/Mage.php';

if (!Mage::isInstalled()) {
   echo "Application is not installed yet, please complete install wizard first.";
   exit;
}

$_SERVER['SCRIPT_NAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_NAME']);
$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_FILENAME']);

Mage::app();
Mage::app()->setCurrentStore($storeId);

$storeCode = Mage::getModel('core/store')->load($storeId)->getCode(); 
$websiteId = Mage::getModel('core/store')->load($storeId)->getWebsiteId();
$websiteCode = Mage::getModel('core/website')->load($websiteId)->getCode();

//https://secure.getstdtested.com:443/api/pings.php?token=DTCMD4getstd-live&result=true&id=MEDIVOID
//https://secure.getstdtested.com:443/api/pings.php?token=DTCMD4getstd-home&result=true&id=MEDIVOID


//https://secure.getstdtested.com/api/pnmConf.php

$req = Mage::app()->getRequest()->getRequestUri();

$req = str_ireplace('/api/pnm.php','',$req);

$ch=curl_init();
 curl_setopt($ch,CURLOPT_URL,'https://secure.getstdtested.com/api/pnmConf.php'.$req);
 curl_exec($ch);
 curl_close($ch);

$params = Mage::app()->getRequest()->getParams(); 

mail('ljrweb@gmail.com','ERROR',print_r($params,true));

$result = (object)Mage::app()->getRequest()->getParams();
	    $order = Mage::getResourceModel('sales/order_collection')
        			  ->addAttributeToFilter('pnm_order_identifier', $result->pnm_order_identifier)
					  ->getData();
					  
	
		$myOrder = Mage::getModel('sales/order')->load($order[0]['entity_id']);
		
		mail('ljrweb@gmail.com','ERROR',print_r($myOrder->getData(),true));
			
		$orderId     = $myOrder->getId();
		$incrementId = $myOrder->getIncrementId();
		
		if(!$orderId)
			Mage::throwException(Mage::helper('core')->__('Cannot create an invoice.'));
			
$invoice = Mage::getModel('sales/service_order', $myOrder)->prepareInvoice();
							
							if (!$invoice->getTotalQty()) 
									Mage::throwException(Mage::helper('core')->__('Cannot create an invoice without products.'));
							
							 $invoice->register()->pay();
						
							
					Mage::getModel('core/resource_transaction')
					->addObject($invoice)
					->addObject($invoice->getOrder())
					->save();
					$invoice->save();
							
$myOrder->addStatusToHistory(Mage_Sales_Model_Order::STATE_PROCESSING,'Callback was successfully executed by PNM');


