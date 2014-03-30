<?php

class Jag_Reporting_Block_Adminhtml_Rep_Renderer_Paynow extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
		$aff = $row->getAffiliateId();
		
		$sales= Mage::getModel('sales/order')->getCollection();
		$collection->getSelect()->joinLeft('sales_flat_order_payment', '`sales_flat_order_payment`.parent_id=main_table.entity_id and sales_flat_order_payment.method = "paynearme"', array('method'=>'method', null,'left');
   		$sales->addFieldToFilter('main_table.affiliate_id',array('eq'=>$aff));
   		$sales->addExpressionFieldToSelect('total_c',"SUM(main_table.total_paid)",'`main_table`.total_paid');
   		
   		echo $sales->getSelect()->__toString(); exit();
   		   		
   		foreach ($sales->getItems() as $sale) {
   		
   			$s = $sale->getTotalC();
   		
   		}
   		
   		$row->setTotalCash($s);
   		
				
		return ($s>0?$s:"0");

	}


}