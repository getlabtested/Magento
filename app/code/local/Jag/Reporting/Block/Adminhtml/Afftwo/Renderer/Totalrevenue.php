<?php

class Jag_Reporting_Block_Adminhtml_Afftwo_Renderer_Totalrevenue extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
		$aff = $row->getAffiliateId();
		
		$sales = Mage::getModel('sales/order')->getCollection();
		$sales->addExpressionFieldToSelect('total_revenue',"SUM(`main_table`.grand_total)",'`main_table`.grand_total');
		$sales->addFieldToFilter('main_table.ppmd_affiliate',array('eq'=>$aff));
		$sales->addFieldToFilter('main_table.ppmd_rep',array('eq'=>99));
		
		//echo $sales->getSelect()->__toString(); exit();
		
		$params = Mage::helper('adminhtml')->prepareFilterString(Mage::app()->getRequest()->getParam('filter'));
		
		if ($params['created_at'] && is_array($params['created_at'])) {
		
		$from = $params['created_at']['from'];
		
		$from = date('Y-m-d',strtotime($from));
		
		$to = $params['created_at']['to'];
		
		$to = date('Y-m-d',strtotime($to));
		
		$sales->addFieldToFilter('main_table.updated_at',array('gt'=>$from));
		$sales->addFieldToFilter('main_table.updated_at',array('lt'=>$to));
		
		}
   		
   		//echo $sales->getSelect()->__toString(); exit();
   		   		
   		foreach ($sales->getItems() as $sale) {
   		
   			$s = $sale->getTotalRevenue();
   		
   		}
   		   		
   		$row->setTotalrevenue($s);
				
		return (($s && $s > 0)?'$'.round($s,2):"0");

	}


}