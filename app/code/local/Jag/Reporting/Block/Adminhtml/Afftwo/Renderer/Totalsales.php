<?php

class Jag_Reporting_Block_Adminhtml_Afftwo_Renderer_Totalsales extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
		$aff = $row->getAffiliateId();
		
		$collection = Mage::getModel('sales/order_invoice')->getCollection();
		$collection->addFieldToSelect('entity_id');
		$collection->addExpressionFieldToSelect('total_paid',"SUM(main_table.grand_total)",'`main_table`.grand_total');
		$collection->addExpressionFieldToSelect('total_refunded',"SUM(main_table.base_total_refunded)",'`main_table`.base_total_refunded');
		$collection->join('sales/order_payment','`sales/order_payment`.parent_id=main_table.order_id',array('method'=>'method'));
		$collection->join('sales/order','`sales/order`.entity_id=main_table.order_id',array());
		$collection->addFieldToFilter('`sales/order`.affiliate_id',array('eq'=>$row->getAffiliateId()));
		$collection->addFieldToFilter('`sales/order`.ppmd_rep',array('eq'=>99));
		
		$params = Mage::helper('adminhtml')->prepareFilterString(Mage::app()->getRequest()->getParam('filter'));
		
		if ($params['created_at'] && is_array($params['created_at'])) {
		
		$from = $params['created_at']['from'];
		
		$from = date('Y-m-d',strtotime($from));
		
		$to = $params['created_at']['to'];
		
		$to = date('Y-m-d',strtotime($to));
		
		$collection->addFieldToFilter('main_table.updated_at',array('gt'=>$from));
		$collection->addFieldToFilter('main_table.updated_at',array('lt'=>$to));
		
		}
   		
   		//echo $collection->getSelect()->__toString(); exit();
   		   		   		
   		foreach ($collection->getItems() as $sale) {
   		
   			$s = $sale->getTotalPaid();
   			$r = $sale->getTotalRefunded();
   			   		
   		}
   		   		
   		if ($s && $s > 0){
   		
   			$s = '$'.round($s,2);
   			
   		} else {
   		
   			$s = 0;
   		
   		}
   		   		
   		$row->setTotalPaid($s);
   		
   		if ($r && $r > 0){
   		
   			$r = '$'.round($r,2);
   			
   		} else {
   		
   			$r = 0;
   		
   		}
   		   		
   		$row->setTotalRefunded($r);
   		
   		
   		$csales = Mage::getModel('sales/order')->getCollection();
		$csales->addFieldToSelect('entity_id');
		$csales->addExpressionFieldToSelect('c',"COUNT(entity_id)",'entity_id');
		$csales->addFieldToFilter('ppmd_affiliate',array('eq'=>$aff));
		$csales->addFieldToFilter('ppmd_rep',array('eq'=>99));
		//$csales->addFieldToFilter('status',array('eq'=>'complete'));
   		
   		if ($params['created_at'] && is_array($params['created_at'])) {
		
		$from = $params['created_at']['from'];
		
		$from = date('Y-m-d',strtotime($from));
		
		$to = $params['created_at']['to'];
		
		$to = date('Y-m-d',strtotime($to));
		
		$csales->addFieldToFilter('updated_at',array('gt'=>$from));
		$csales->addFieldToFilter('updated_at',array('lt'=>$to));
		
		}
		
		//echo $csales->getSelect()->__toString(); exit();
   		
   		foreach ($csales->getItems() as $csale) {
   		   			
   			$c = $csale->getC();
   		
   		}
   		
   		$con = ($c/$row->getTotalCalls())*100;
   		
   		$row->setConversion(round($con,2).'%');
   						
		return $c;

	}


}