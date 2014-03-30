<?php

class Jag_Tests_Block_Adminhtml_Tests_Renderer_Tests extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {

		
			$c = Mage::getModel('tests/tests')
				->getCollection()
				->addFieldToFilter('customer_id',array('eq'=>$row->getCustomerId()))
				->addFieldToFilter('result',array('eq'=>1));
						
			$tstring = '';
			
			foreach ($c->getItems() as $item) {
			
				$tstring .= $item->getTestName().",";
			
			}
					
		return rtrim($tstring,",");

	}
	
}