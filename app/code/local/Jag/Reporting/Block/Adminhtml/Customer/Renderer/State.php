<?php

class Jag_Reporting_Block_Adminhtml_Customer_Renderer_State extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
		$value =  $row->getData($this->getColumn()->getIndex());
		
		if (!$value) {
		
			$c = Mage::getModel('customer/customer')->load($row->getCustomerId());
			
			$db = $c->getDefaultBilling();
			
			if ($db){
       			$address = Mage::getModel('customer/address')->load($db);
       			
				$st = $address->getRegionId();
				
				$state = Mage::getModel('directory/region')->load($st)->getCode();
				
				return($state);
       			
			}
			
			
		
		}
		
		return $value;

	}


}