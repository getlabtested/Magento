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
 * @package     Mage_Checkout
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 * Multishipping checkout controller
 * 
 * @author      Magento Core Team <core@magentocommerce.com>
 */

 require_once 'Mage/Checkout/controllers/OnePageController.php';
// 
class Jag_Paylater_OnePageController extends Mage_Checkout_OnepageController
{
    // /**
     // * Multishipping checkout succes page
     // */
    // public function successAction()
    // {
        // $session = $this->getOnepage()->getCheckout();
//         
		// if (!$session->getLastSuccessQuoteId()) {
            // $this->_redirect('checkout/cart');
            // return;
        // }
// 
        // $lastQuoteId = $session->getLastQuoteId();
        // $lastOrderId = $session->getLastOrderId();
        // $lastRecurringProfiles = $session->getLastRecurringProfileIds();
        // if (!$lastQuoteId || (!$lastOrderId && empty($lastRecurringProfiles))) {
            // $this->_redirect('checkout/cart');
            // return;
        // }
//         
        // /* call the PNM API START */
       // // Mage::helper('paynearme')->processPaynearMe($lastOrderId);
        // /* call the PNM API END */
//         
        // $session->clear();
        // $this->loadLayout();
        // $this->_initLayoutMessages('checkout/session');
        // Mage::dispatchEvent('checkout_onepage_controller_success_action', array('order_ids' => array($lastOrderId)));
        // $this->renderLayout();
    // }
// 	
	// public function confirmAction(){
// 		
		// $paynearme = Mage::getModel('paynearme/paymentmethod');
		// if($paynearme->confirmPayment()){
			// header('Content-type:text/xml');	
			// echo "<t:payment_confirmation_response
					// xsi:schemaLocation='http://www.paynearme.com/public/api/pnm_xmlschema_v1_5 pnm_xmlschema_v1_5.xsd'
					// xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'
					// xmlns:t='http://www.paynearme.com/public/api/pnm_xmlschema_v1_5' version='1.5'>
					// <t:confirmation>
						// <t:pnm_order_identifier>".$this->getRequest()->getParam('pnm_order_identifier')."</t:pnm_order_identifier>
					// </t:confirmation>
				// </t:payment_confirmation_response>" ;
			// exit;
		// }
	// }
// 	
// 	
// 
}
