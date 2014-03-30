<?php
class Jag_Paylater_Block_Info extends Mage_Payment_Block_Info
{
    protected function _construct(){
        parent::_construct();
        $this->setTemplate('paylater/info.phtml');
    }  
	
	public function getMethodCode(){
        return $this->getInfo()->getMethodInstance()->getCode();
    }
	
	public function getMethodTitle(){
		return Mage::getStoreConfig('payment/paylater/title');
	}
	
	public function getMethodPaymentOption(){
		$form_data = Mage::app()->getRequest()->getParams();
		
	}

}