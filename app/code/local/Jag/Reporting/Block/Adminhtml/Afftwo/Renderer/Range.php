<?php

class Jag_Reporting_Block_Adminhtml_Afftwo_Renderer_Range extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
		
		$params = Mage::helper('adminhtml')->prepareFilterString(Mage::app()->getRequest()->getParam('filter'));
		
		if ($params['created_at'] && is_array($params['created_at'])) {
		
		$from = $params['created_at']['from'];
		
		$from = date('Y-m-d',strtotime($from));
		
		$to = $params['created_at']['to'];
		
		$to = date('Y-m-d',strtotime($to));
		
		return $params['created_at']['from']." - ".$params['created_at']['to'];
		
		}
   		
				
		return;

	}


}