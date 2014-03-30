<?php

class Jag_Sendmail_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    // public function sendAction() {
        // if ($data = $this->getRequest()->getPost()) {
            // try {
                // $postObject = new Varien_Object();
                // $postObject->setData($data);
                // $mailTemplate = Mage::getModel('core/email_template');
                // $mailTemplate->setDesignConfig(array('area' => 'frontend'))
                        // ->sendTransactional(
                                // $data['template'], array('email' => $data['email'], 'name' => "Customer"), Mage::getStoreConfig('trans_email/ident_general/email'), null, array('data' => $postObject)
                // );
                // $mailTemplate->getSentSuccess();
                // echo "You email has been sent successfully.";
                // exit;
            // } catch (Exception $e) {
                // echo "Error:".$e->getMessage();
                // exit;
//                 
            // }
        // }
    // }
	
	public function sendAction() {
		
		
		$mailer = Mage::getModel('core/email_template_mailer');
        
        $emailInfo = Mage::getModel('core/email_info');
        $emailInfo->addTo("ljrweb@gmail.com", "Logan Robbins");

        $mailer->addEmailInfo($emailInfo);
		
		$templateId = Mage::getStoreConfig('sales_email/order/template', $storeId);
		
        $mailer->setSender('info@getlabtested.net');
        $mailer->setStoreId($storeId);
        $mailer->setTemplateId('custom_email_template');
        $mailer->setTemplateParams(array(
                'order'        => "test",
                'billing'      => "test",
                'payment_html' => "test"
            )
        );
        $mailer->send();
		
		
	}
	
	

}