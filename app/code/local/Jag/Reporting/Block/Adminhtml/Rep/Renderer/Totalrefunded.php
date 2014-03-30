<?php

class Jag_Reporting_Block_Adminhtml_Rep_Renderer_Totalrefunded extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
		   						
		return $row->getTotalRefunded();

	}


}