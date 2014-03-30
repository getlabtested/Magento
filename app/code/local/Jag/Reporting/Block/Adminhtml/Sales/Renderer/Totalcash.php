<?php

class Jag_Reporting_Block_Adminhtml_Sales_Renderer_Totalcash extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
		$r =   substr($row->getTotalRefunded(),1);
		
		if ($r < 1) {
		
			$r = 0;
		
		}
		
		$p = substr($row->getTotalPaid(),1);
		
		$t = $p - $r;
		
		
		   						
		return "$".$t;

	}


}