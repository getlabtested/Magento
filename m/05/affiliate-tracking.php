<?php // PAP Header Tracking	
	
if (isset($_GET['a_aid'])) {
	$_SESSION['a_aid'] = $_GET['a_aid'];
}

if (isset($_SESSION['a_aid'])) { //create div for tracking

	$hostname = "10.180.68.225";
	$username = "magento";
	$password = "magento$4ppmd";
	$dbname = "magento";

	$link = mysql_connect("$hostname", "$username", "$password");
	
	if ($link) {

		mysql_select_db("$dbname", $link);		
		$result = mysql_query('SELECT phone FROM affiliates WHERE referral_id = "'.$_SESSION['a_aid'].'" LIMIT 1;');		
		$phone = mysql_fetch_row($result);
		$phone = $phone[0];
		
	}	
	
	mysql_close($link);
		
	// $config  = Mage::getConfig()->getResourceConnectionConfig("default_setup");

	// $db = new PDO ('mysql:dbname='.$config->dbname.';host='.$config->host, $config->username, $config->password);

	// $affiliate_exists = false;
	
	// Mage::getSingleton('core/session')->setAffiliateId($_SESSION['a_aid']);
	// Mage::getSingleton('core/session')->setPpmdAffiliate($_SESSION['a_aid']);
	
	// $q = 'select phone from affiliates where referral_id = "'.$_SESSION['a_aid'].'";';
	
		// $sth = $db->prepare($q);
		// $sth->setFetchMode(Zend_Db::FETCH_ASSOC);
    	// $sth->execute();  
    		
    	// $res = $sth->fetchAll();
    	
    	// $sth = "";
    	        	    	
    // $phone = $res[0]['phone'];

	if ($phone != ''){
				
			$phone = str_replace("-","",$phone);
			$phone = str_replace(".","",$phone);
			$phone = str_replace(" ","",$phone);
			
			$p1 = substr($phone,0,3);
			$p2 = substr($phone,3,3);
			$p3 = substr($phone,6,4);

			$phone = $p1."-".$p2."-".$p3;

		?>
		
		<div id="affiliate" style="display:none;">
			<div class="promoNumber">
				<?php echo $phone; ?>
			</div>
		</div>
		
		<?php
		
	} else {
	
		$phone = "877-647-9251";
	
	}	
	
}

// END PAP Header Tracking

?>