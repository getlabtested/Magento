<?php

class Jag_Reporting_Block_Adminhtml_Rep_Renderer_Stuff extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
		$c = Mage::getModel('customer/customer')->load($row->getCustomerId());
			
		return $c->getFirstname();

	}


}