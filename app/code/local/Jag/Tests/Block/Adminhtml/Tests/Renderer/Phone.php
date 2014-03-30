<?php

class Jag_Tests_Block_Adminhtml_Tests_Renderer_Phone extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {

		
			$c = Mage::getModel('customer/customer')->load($row->getCustomerId());
			
			$db = $c->getDefaultBilling();
			
			if ($db){
       			$address = Mage::getModel('customer/address')->load($db);
       			
				$phone = $address->getTelephone();
				
				if ($phone) {
				
				return($phone);
				
				} else {
				
					return $c->getPpmdPhone();
				
				}
       			
			}
			

	return '';
	
	}
	
}
