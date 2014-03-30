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

$db = new PDO ('mysql:dbname='.$config->dbname.';host='.$config->host, $config->username, $config->password);

$h = fopen("mail-log.txt","w+");

$t = time();

$today = date('Y-m-d h:i:s',$t);

$y = $t - 86400;

$yesterday = date('Y-m-d h:i:s',$y);

$a = "select a.entity_id,a.created_at from sales_flat_order as a join sales_flat_order_payment as b on b.parent_id = a.entity_id where b.method = 'paynearme' and a.status = 'processing' and a.ppmd_activate = 0 and a.com_activate = 0;";

				
$sth = $db->prepare($a);
$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
$sth->execute();  
	
$res = $sth->fetchAll();

for ($i = 0; $i <= count($res)-1; $i++) {

	$c = strtotime($res[$i]['created_at']);
		echo $res[$i]['created_at']."  ";
		
		echo $y-$c; echo "\n";
		
	if ($y - $c >= 86400) {
	
		try {
	
		echo "Activation email: ".$res[$i]['entity_id'];
		echo "\n";
				
		fwrite($h,"Activation email: ".$res[$i]['entity_id']);
		fwrite($h,"\n");
		
		Mage::getModel('sendmail/sendmail')->sendEmail($res[$i]['entity_id'],'ppmd_pwc_order_activation_reminder_1');
		
		$q = "update sales_flat_order set com_activate = 1 where entity_id = ".$res[$i]['entity_id'].";";
		$sth = $db->prepare($q);
		$sth->execute();
		
		sleep(60);
		
		} catch (Exception $e) {
		
			print_r($e->getMessage()); 
		
		}
			
	}

}


echo "starting payment emails.. \n";

$a = "select a.entity_id,a.created_at from sales_flat_order as a join sales_flat_order_payment as b on b.parent_id = a.entity_id where b.method = 'paynearme' and a.status = 'processing' and a.ppmd_activate = 1  and a.com_pwc_a = 0;";

//$a = "select a.entity_id,a.created_at from sales_flat_order as a join sales_flat_order_payment as b on b.parent_id = a.entity_id where b.method = 'paynearme' and a.status = 'processing' and a.entity_id = 2041;";
				
$sth = $db->prepare($a);
$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
$sth->execute();  
	
$res = $sth->fetchAll();

for ($i = 0; $i <= count($res)-1; $i++) {

	$c = strtotime($res[$i]['created_at']);
	
	if ($y - $c >= 691200) {
	
		try {
		
		echo "Payment email: ".$res[$i]['entity_id'];
		echo "\n";
		
		fwrite($h,"Payment email: ".$res[$i]['entity_id']);
		fwrite($h,"\n");
				
	
		Mage::getModel('sendmail/sendmail')->sendEmail($res[$i]['entity_id'],'ppmd_pwc_reminder_8');
		
		$q = "update sales_flat_order set com_pwc_a = 1 where entity_id = ".$res[$i]['entity_id'].";";		
		$sth = $db->prepare($q);
		$sth->execute();
		
		sleep(60);
		
		} catch (Exception $e) {
		
			print_r($e->getMessage()); 
		
		}
			
	}

}

fclose($h);

exit();

