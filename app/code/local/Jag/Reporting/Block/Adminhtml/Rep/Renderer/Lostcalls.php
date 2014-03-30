<?php

class Jag_Reporting_Block_Adminhtml_Rep_Renderer_Lostcalls extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
		$aff = $row->getAffiliateId();
		
		$sales= Mage::getModel('sales/order')->getCollection();
   		$sales->addFieldToFilter('affiliate_id',array('eq'=>$aff));
   		$sales->addExpressionFieldToSelect('total_sales',"COUNT(main_table.entity_id)",'`main_table`.entity_id');
   		
   		//echo $sales->getSelect()->__toString(); exit();
   		   		
   		foreach ($sales->getItems() as $sale) {
   		
   			$s = $sale->getTotalSales();
   		
   		}
   		
   		$row->setTotalSales($s);
   		
		
		//$row->setTotalCalls($c+$c2);
		
		return (($row->getTotalCalls() - $s)>0?$row->getTotalCalls() - $s:"0");

	}


}