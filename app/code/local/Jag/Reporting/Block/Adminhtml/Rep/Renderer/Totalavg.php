<?php

class Jag_Reporting_Block_Adminhtml_Rep_Renderer_Totalavg extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
		return(round($row->getTotalrevenue()/$row->getTotalSalesCount(),2));

	}


}