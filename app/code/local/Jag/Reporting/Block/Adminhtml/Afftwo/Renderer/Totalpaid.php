<?php

class Jag_Reporting_Block_Adminhtml_Afftwo_Renderer_Totalpaid extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
		   						
		return $row->getTotalPaid();

	}


}