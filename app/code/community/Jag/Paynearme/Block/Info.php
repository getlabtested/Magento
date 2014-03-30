<?php
class Jag_Paynearme_Block_Info extends Mage_Payment_Block_Info
{
    protected function _construct(){
        parent::_construct();
        $this->setTemplate('paynearme/info.phtml');
    }  
	
	public function getMethodCode(){
        return $this->getInfo()->getMethodInstance()->getCode();
    }
	
	public function getMethodTitle(){
		return Mage::getStoreConfig('payment/paynearme/title');
	}
	
	public function getMethodPaymentOption(){
		$form_data = Mage::app()->getRequest()->getParams();
		
	}

}