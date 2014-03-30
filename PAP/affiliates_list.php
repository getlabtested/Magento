<?php

include 'PapApi.class.php';

//----------------------------------------------
// login (as merchant)

$pap_credentials_helper = Mage::helper('ppmd_credentials/pap');
$stores_with_credentials = $pap_credentials_helper->getAllStoreCredentials();

foreach($stores_with_credentials as $store_code => $store_credentials)
{
    $username = $store_credentials['username'];
    $password = $store_credentials['password'];
    $server_url = $store_credentials['server']['url'];

    $session = new Gpf_Api_Session($server_url);

    if(!$session->login($username, $password)) {
    //if(!$session->login("merchant@example.com","demo")) {
        die("Cannot login. Message: ".$session->getMessage());
    }

    //----------------------------------------------
    // get recordset with list of affiliates
    $request = new Pap_Api_AffiliatesGrid($session);
    // sets limit to 30 rows, offset to 0 (first row will start)
    $request->setLimit(0, 20);
    //----------------------------------------------
    // send request
    try {
        $request->sendNow();
    } catch(Exception $e) {
        die("API call error: ".$e->getMessage());
    }

    //----------------------------------------------
    // request was successful, get the grid result
    $grid = $request->getGrid();
    //----------------------------------------------
    // get recordset from the grid
    $recordset = $grid->getRecordset();
    echo 'Total number of affiliates: '.$grid->getTotalCount().'<br>';
    echo 'Number of affiliates returned in result: '.$recordset->getSize();

    // iterate through the records
    foreach($recordset as $rec) {
        print_r($rec);
        echo '<br/>';
        echo 'Affiliate name: '.$rec->get('firstname').' '.$rec->get('lastname').' - '.$rec->get('data10').'<br>';
    }
}

?>