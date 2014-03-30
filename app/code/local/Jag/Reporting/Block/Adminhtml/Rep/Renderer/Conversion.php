<?php

class Jag_Reporting_Block_Adminhtml_Rep_Renderer_Conversion extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
		//echo "<pre>"; print_r($row->getData()); exit();
	
		$tc = $row->getTotalCalls();
		
		$ts = $row->getTotalSales();
				
		$cr = round(($ts/$tc)*100,2);
		
		return "%".$cr;

	}

}