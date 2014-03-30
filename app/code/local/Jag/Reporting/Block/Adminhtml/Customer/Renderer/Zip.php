<?php

class Jag_Reporting_Block_Adminhtml_Customer_Renderer_Zip extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
		$value =  $row->getData($this->getColumn()->getIndex());
		
		if (!$value) {
		
			$c = Mage::getModel('customer/customer')->load($row->getCustomerId());
			
			$db = $c->getDefaultBilling();
			
			if ($db){
       			$address = Mage::getModel('customer/address')->load($db);
       			
				$zip = $address->getPostalcode();
								
				return($zip);
       			
			}
			
			
		
		}
		
		return $value;

	}


}