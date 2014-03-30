<?php

class Jag_Reporting_Block_Adminhtml_Rep_Renderer_Range extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
	
		$params = Mage::helper('adminhtml')->prepareFilterString(Mage::app()->getRequest()->getParam('filter'));
		
			//print_r($params);
			
			if ($params['created_at']['from']) {
				
		return $params['created_at']['from']." - ".$params['created_at']['to'];
		
		} else {
		
			return "Total";
		
		}

	}

}