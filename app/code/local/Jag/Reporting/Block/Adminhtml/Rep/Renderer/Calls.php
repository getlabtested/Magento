<?php

class Jag_Reporting_Block_Adminhtml_Rep_Renderer_Calls extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
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
		
		$collect = Mage::getModel('sales/quote')->getCollection();
		
		if (null === $ppmdRep) {
		
			$collect->addFieldToFilter('ppmd_rep',array('null'=>true));
		
		} else {
		
			$collect->addFieldToFilter('ppmd_rep',array('eq'=>$ppmdRep));
			$collect->addFieldToFilter('lost_order',array('eq'=>1));
		
		}
		
		$c2 = count($collect->getItems());
		
		$row->setTotalCalls($c+$c2);
		
		return $c;

	}


}