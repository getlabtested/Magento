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

$req = str_replace("/api/pings.php","",Mage::app()->getRequest()->getRequestUri());

$ch=curl_init();
 curl_setopt($ch,CURLOPT_URL,'https://secure.getstdtested.com:443/api/pings.php'.$req);
 curl_exec($ch);
 curl_close($ch);

/*
Mage::Log('MEDIVO POST');
Mage::Log($encoded);
Mage::Log(print_r(Mage::app()->getRequest()->getRequestUri(),true));
*/

//mail("jagppmd@gmail.com",'medivo ping',Mage::app()->getRequest()->getRequestUri());

$ppmdCustId = Mage::app()->getRequest()->getParam('id');
$res = Mage::app()->getRequest()->getParam('result');

if ($res) {

$collection = Mage::getModel('sales/order')->getCollection()
	->addFieldToFilter('ppmd_cust_id',array('eq'=>$ppmdCustId));
	
	//echo $collection->getSelect()->__toString(); exit();

foreach ($collection->getItems() as $item) {

	$o = $item;

}

	$o->setPpmdStatus(1);
	$o->addStatusToHistory($o->getState(),'Callback was successfully executed by PNM');
	$o->save();

}


exit();
