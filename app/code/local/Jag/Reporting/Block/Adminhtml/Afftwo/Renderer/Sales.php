<?php

class Jag_Reporting_Block_Adminhtml_Afftwo_Renderer_Sales extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
		$ppmdRep = $row->getPpmdRep();
				
		$collection = Mage::getModel('sales/order')->getCollection();
		
		if (null === $ppmdRep) {
		
			$collection->addFieldToFilter('ppmd_rep',array('null'=>true));
		
		} else {
		
			$collection->addFieldToFilter('ppmd_rep',array('eq'=>$ppmdRep));
		
		}
		
		//echo $collection->getSelect()->__toString(); exit();
		
		$c = count($collection->getItems());
		
		$row->setTotalSales($c);
		
		return $c;

	}


}