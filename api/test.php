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

$config  = Mage::getConfig()->getResourceConnectionConfig("default_setup");

//$db = new PDO ('mysql:dbname='.$config->dbname.';host='.$config->host, $config->username, $config->password);

$c = Mage::getModel('sales/order')->getCollection()->addFieldToFilter('ppmd_provider',array('eq'=>2));

foreach ($c->getItems() as $order) {

	$labRevenue = 0;

	$items = $order->getAllItems();

        foreach ($items as $item) {	

	$id = Mage::getModel('catalog/product')->getIdBySku($item->getSku());
	

	$labRevenue = $labRevenue + Mage::getModel('catalog/product')->load($id)->getPriceOptOne();


	}



	$order->setLabRevenue($labRevenue)->save();

}

