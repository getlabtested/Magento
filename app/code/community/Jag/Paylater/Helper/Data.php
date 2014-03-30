<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Paypal
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 * Paypal Data helper
 */
class Jag_Paylater_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function processPaylater($orderId) {
        
       /*
 $curTimestamp = time();
        $labzip = "1453"; 
        
        $myOrder=Mage::getModel('sales/order');
        $myOrder->load($orderId);
        $_totalData = $myOrder->getData();
        
        $email = $_totalData['customer_email'];
        $customerGuest = $_totalData['customer_is_guest'];
        $totalcost = round($_totalData['base_grand_total'], 2);
        
        $siteName = Mage::getStoreConfig('payment/paynearme/site_customer_name');
        $siteIdentifier = Mage::getStoreConfig('payment/paynearme/site_identifier');
        $siteKey = Mage::getStoreConfig('payment/paynearme/site_key');
        $version = Mage::getStoreConfig('payment/paynearme/version');
        $paynearme_host = Mage::getStoreConfig('payment/paynearme/host');;
        $billingAddressId = $_totalData['billing_address_id'];
        
        if($customerGuest == "1"){
            $custID = "Guest";
        }else{
            $custID = $_totalData['customer_id'];
        }

        $paynearme_values	= array 
            (                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                    "order_amount"  => $totalcost,
                    "order_currency"	=> "USD",
                    "order_type"	=> "exact",
                    "site_customer_email"	=> $email,
                    "site_customer_name" => $siteName,                                                           
                    "site_customer_identifier"	=> $custID,
                    "site_customer_postal_code" => $labzip,
                    "timestamp"	=> $curTimestamp,
                    "version"	=> $version,
                    "site_identifier"	=> $siteIdentifier
            );
         
         ksort($paynearme_values);

        $sigStr="";
        foreach ($paynearme_values as $key => $value)
        {
         $sigStr.=$key.$value; 
        }
        $sigStr .= $siteKey;

        $signature = md5($sigStr);

        $paynearme_values['signature'] = $signature;

        $fields = "";
	foreach( $paynearme_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";
	
	
	
	$ch = curl_init($paynearme_host);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
	curl_setopt($ch, CURLOPT_HEADER, 0); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $fields, "& " )); 
        $resp = curl_exec($ch);
        if(false === $resp) {
            $message = "Customer ID: " . $custID . " Curl response to " . $paynearme_host . " failed. Curl error: " . curl_error($ch);
            ppmdCritical($message, true);
            $message = "System unavailable at this moment, please try again later.";
            ppmdFatalError($message);
            exit();
        }
        if(empty($resp)) {
            $message = "Customer ID: " . $custID . " Curl response to " . $paynearme_host . " failed. No content. Curl error: " . curl_error($ch);
            ppmdCritical($message, true);
            $message = "System unavailable at this moment, please try again later.";
            ppmdFatalError($message);
            exit();
        }
	curl_close ($ch);
	
	//echo "\r\n<!--$resp-->\r\n";
	global $paynearmeResponseString; 
	$paynearmeResponseString = $resp;
	$xml = simplexml_load_string($resp);
	
	$resultStatus = $xml->attributes();
        
        if($xml['status'] == "ok"){
	    return true;
	}else{
            return false;
        }
    }
*/

}
}
