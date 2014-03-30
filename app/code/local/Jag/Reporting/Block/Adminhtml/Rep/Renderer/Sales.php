<?php

class Jag_Reporting_Block_Adminhtml_Rep_Renderer_Sales extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
	
		$params = Mage::helper('adminhtml')->prepareFilterString(Mage::app()->getRequest()->getParam('filter'));
		
			//print_r($params);
			
			
		
	
		$ppmdRep = $row->getPpmdRep();
				
		$collection = Mage::getModel('sales/order')->getCollection();
		
		if (null === $ppmdRep) {
		
			$collection->addFieldToFilter('ppmd_rep',array('null'=>true));
		
		} else {
		
			$collection->addFieldToFilter('ppmd_rep',array('eq'=>$ppmdRep));
		
		}
		
		if ($params['updated_at']['from']) {
		
		$from = strtotime($params['updated_at']['from']);
		
		$from = date('Y-m-d',$from);
		
		$to = strtotime($params['updated_at']['to']);
		
		$to = date('Y-m-d',$to);
		
			$collection->addFieldToFilter('updated_at',array('gt'=>$from));
		
			$collection->addFieldToFilter('updated_at',array('lt'=>$to));
		
		}
		
		
		
		//echo $collection->getSelect()->__toString(); exit();
		
		$c = count($collection->getItems());
		
		$row->setTotalSales($c);
		
		return $c;

	}


}