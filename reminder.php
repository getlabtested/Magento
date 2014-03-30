<?php
ini_set("memory_limit","-1"); ini_set('auto_detect_line_endings', true);
ini_set("display_errors",1);
date_default_timezone_set('America/Los_Angeles');

$storeId = 0;

$status = 1;

require 'app/Mage.php';

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

$db = new PDO ('mysql:dbname='.$config->dbname.';host='.$config->host, $config->username, $config->password);

$d = date('Y-m-d H:i:s');

$q = "select b.entity_id from sales_flat_order_payment as a join sales_flat_order as b on b.entity_id = a.parent_id where a.method = 'paynearme' and b.ppmd_status = 0 and b.status = 'processing';";

$sth = $db->prepare($q);
$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
$sth->execute();  
	
$res = $sth->fetchAll();

for ($i = 0; $i<= count($res)-1; $i++) {

	$orderId = $res[$i]['entity_id'];
	
	try {

	Mage::getModel('sendmail/sendmail')->sendEmail($orderId,'ppmd_pwc_reminder');
	
	echo $i." $orderId now sleeping… \n";
	
	sleep(30);
	
	} catch (Exception $e) {
	
		print_r($e->getMessage());
	
	}

}



