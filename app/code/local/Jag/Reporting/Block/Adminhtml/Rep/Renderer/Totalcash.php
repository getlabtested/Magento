<?php

class Jag_Reporting_Block_Adminhtml_Rep_Renderer_Totalcash extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
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

/*
class Jag_Reporting_Block_Adminhtml_Rep_Renderer_Totalcash extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
		$aff = $row->getAffiliateId();
		
		$sales = Mage::getModel('sales/order')->getCollection();
		$sales->getSelect()->joinLeft('sales_flat_order_payment', '`sales_flat_order_payment`.parent_id=main_table.entity_id', array('method'=>'method'), null,'left');
		$sales->addExpressionFieldToSelect('total_revenue',"SUM(`main_table`.total_paid)",'`main_table`.total_paid');
		$sales->addFieldToFilter('main_table.affiliate_id',array('eq'=>$aff));
		$sales->addFieldToFilter('sales_flat_order_payment.method',array('eq'=>'paynearme'));
   		
   		//echo $sales->getSelect()->__toString(); exit();
   		   		
   		foreach ($sales->getItems() as $sale) {
   		
   			$s = $sale->getTotalRevenue();
   		
   		}
   		   		
   		$row->setTotalcash($s);
				
		return (($s && $s > 0)?'$'.round($s,2):"0");

	}


}
*/