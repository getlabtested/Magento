<?php


class Gemini_Affiliates_Model_Observer  

{

	public function syncPapAffiliates() {

		//$classfile = '/_hosting/_gd/_pointmd_v2/lib/PAP/PapApi.class.php';
		$classfile = '/home/webapps/sites/magento/public/lib/PAP/PapApi.class.php';  
		
		if(!file_exists($classfile)) die('PAP API Class file does not exists'); 
		include $classfile;

        $pap_credentials_helper = Mage::helper('ppmd_credentials/pap');
        $stores_with_credentials = $pap_credentials_helper->getAllStoreCredentials();

        foreach($stores_with_credentials as $store_code => $store_credentials)
        {
            $username = $store_credentials['username'];
            $password = $store_credentials['password'];
            $server_url = $store_credentials['server']['url'];

            $this->syncPapAffiliate($server_url, $username, $password);
        }
    }

    public function syncPapAffiliate($server_url, $username, $password)
    {
        // initial vars
        $i = 0; // tracking var
        $j = 0; // tracking var

        $session = new Gpf_Api_Session($server_url);
		
		if(!$session->login($username,$password)) {
		  die("Cannot login. Message: ".$session->getMessage());
		}

		$request = new Pap_Api_AffiliatesGrid($session);
		//$request->setLimit(0, 73); 
		
		// send request
		try {
		  $request->sendNow();
		} catch(Exception $e) {
		  die("API call error: ".$e->getMessage());
		}
		
		$grid = $request->getGrid();
		
		// get total  count
		$total_count = $grid->getTotalCount();
		
		$request->setLimit(0, $total_count); 
		
		// send request again for full results
		try {
		  $request->sendNow();
		} catch(Exception $e) {
		  die("API call error: ".$e->getMessage());
		}
		
		// get grid results
		$grid = $request->getGrid();

		// get recordset from the grid
		$recordset = $grid->getRecordset();
		
		// get local records
		$model =  Mage::getModel('affiliates/affiliates');
		$collection = $model->getCollection();
		
		$config  = Mage::getConfig()->getResourceConnectionConfig("default_setup");

		$db = new PDO ('mysql:dbname='.$config->dbname.';host='.$config->host, $config->username, $config->password);
		
		// iterate through the pap records
		foreach($recordset as $rec) {
				
			$aff = Mage::getModel('affiliates/affiliates');
						
			$affiliate = new Pap_Api_Affiliate($session);
			
			$q = 'select id from affiliates where affiliate_id = "'.$rec->get('userid').'";';
			
			$sth = $db->prepare($q);
			$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
    		$sth->execute();  
    		
    		$res = $sth->fetchAll();
    		
    		$id = $res[0]['id'];
			
			if ($id) {
			
				$aff->load($id);
				$aff->setAffiliateId($rec->get('userid'));
				$aff->setReferralId($rec->get('refid'));
				$aff->setPhone($rec->get('data10'));
				$aff->save();
							
			} else {
			
				$aff->setAffiliateId($rec->get('userid'));
				$aff->setReferralId($rec->get('refid'));
				$aff->setPhone($rec->get('data10'));
				$aff->save();
				
			}
						
		} // end foreach
		
		// delete local items that don't exist on PAP		
	}

}
