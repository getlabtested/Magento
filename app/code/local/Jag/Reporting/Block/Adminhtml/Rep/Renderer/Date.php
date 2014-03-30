<?php

class Jag_Reporting_Block_Adminhtml_Rep_Renderer_Date extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
		echo "<pre>";
		print_r($this->getColumn());
		echo "</pre>";		
		//$row->setTotalCalls($c+$c2);
		
		return 1;

	}


}