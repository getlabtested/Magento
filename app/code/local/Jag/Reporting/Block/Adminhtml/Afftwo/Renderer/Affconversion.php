<?php

class Jag_Reporting_Block_Adminhtml_Sales_Renderer_Affconversion extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
		$totalCalls = $row->getTotalCalls();
		
		$totalSales = $row->getTotalSales();
		
		$c = ($totalSales/$totalCalls)*100;
						
		return round($c,2).'%';

	}


}