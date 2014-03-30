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


$query = "select 
	a.entity_id,
	b.entity_id as payment_id, 
	a.created_at, 
	a.increment_id,
	a.grand_total,
	a.total_paid,
	a.total_due,
	b.method,   
	c.email,
	b.additional_information 
from 
	sales_flat_order as a 
	join sales_flat_order_payment as b on b.parent_id = a.entity_id 
	join customer_entity as c on c.entity_id = a.customer_id 
where 
	a.created_at < '2011-11-04' and a.created_at > '2011-11-03';";          
			
	//echo $query; echo "<br>"; 
	
	$h = fopen("report.txt","w+");
     	    
    $sth = $db->prepare($query);
	$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
    $sth->execute();

	while ($row = $sth->fetch()) {
	
		$ad = unserialize($row['additional_information']);
		
		foreach ($ad['authorize_cards'] as $card) {
						
			foreach ($card as $k=>$v) {
			
			
				$row[$k] = $v;
			
			}
		
		}
		
		echo $row['entity_id']."|".$row['increment_id']."|".$row['cc_last4']."|".$row['last_trans_id'];
		echo "\n";
		
		unset($row['additional_information']);
		
		foreach ($row as $k=>$v) {
					
			$dstr .= "$v,";
						
			
				
		}
		
		$dstr = rtrim($dstr,",");
		
		fwrite($h,$dstr);
		fwrite($h,"\n");
		
		
		if (!isset($arrKeys) && $row['method'] == 'authorizenet') {
		
			$arrKeys = array_keys($row);
			
			foreach ($arrKeys as $k=>$v) {
			
				$kstr .= "$v,";
			
			}
			
			$kstr = rtrim($kstr,",");
			
			fwrite($h,$kstr);
			fwrite($h,"\n");
					
		}	
	
	}
