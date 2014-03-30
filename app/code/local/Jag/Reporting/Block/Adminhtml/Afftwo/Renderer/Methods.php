<?php

class Jag_Reporting_Block_Adminhtml_Afftwo_Renderer_Methods extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
	$value =  $this->getColumn()->getIndex();
	
	$params = Mage::helper('adminhtml')->prepareFilterString(Mage::app()->getRequest()->getParam('filter'));
		
	if ($params['created_at'] && is_array($params['created_at'])) {
	
		$from = $params['created_at']['from'];
		
		$from = date('Y-m-d',strtotime($from));
		
		$to = $params['created_at']['to'];
		
		$to = date('Y-m-d',strtotime($to));
	
		$collection = Mage::getModel('sales/order_invoice')->getCollection();
		$collection->addFieldToSelect('entity_id');
		$collection->addExpressionFieldToSelect('c',"count(main_table.entity_id)",'`main_table`.entity_id');
		$collection->addExpressionFieldToSelect('total_paid',"SUM(main_table.grand_total)",'`main_table`.grand_total');
		$collection->addExpressionFieldToSelect('total_refunded',"SUM(main_table.base_total_refunded)",'`main_table`.base_total_refunded');
		$collection->join('sales/order_payment','`sales/order_payment`.parent_id=main_table.order_id',array('method'=>'method'));
		$collection->join('sales/order','`sales/order`.entity_id=main_table.order_id',array());
		$collection->addFieldToFilter('`sales/order`.affiliate_id',array('eq'=>$row->getAffiliateId()));
		$collection->addFieldToFilter('`sales/order`.ppmd_rep',array('eq'=>99));
		$collection->addFieldToFilter('main_table.updated_at',array('gt'=>$from));
		$collection->addFieldToFilter('main_table.updated_at',array('lt'=>$to));
		
		//echo $collection->getSelect()->__toString(); exit();
		
		
		$cc = Mage::getModel('sales/order')->getCollection();
		$cc->addFieldToFilter('main_table.ppmd_affiliate',array('eq'=>$row->getAffiliateId()));
		$cc->addFieldToFilter('main_table.ppmd_rep',array('eq'=>99));
		$cc->addFieldToFilter('main_table.updated_at',array('gt'=>$from));
		$cc->addFieldToFilter('main_table.updated_at',array('lt'=>$to));
		$cc->join('sales/order_payment','`sales/order_payment`.parent_id=main_table.entity_id',array('method'=>'method'));
		
		//echo $collection->getSelect()->__toString();
		
		switch ($value) {
		
			case "authorizenet":
				
				$collection->addFieldToFilter('`sales/order_payment`.method',array('eq'=>'authorizenet'));
				
				$cc->addFieldToFilter('`sales/order_payment`.method',array('eq'=>'authorizenet'));
				
				//echo $cc->getSelect()->__toString();
				
				foreach ($collection->getItems() as $item) {				
				
					$row->setPaynowTotal($item->getTotalPaid());
					//return $item->getC();
				
				}
				
				return $cc->count();
			
			break;
			
			case "paynearme":
				
				$collection->addFieldToFilter('`sales/order_payment`.method',array('eq'=>'paynearme'));
				
				$cc->addFieldToFilter('`sales/order_payment`.method',array('eq'=>'paynearme'));
				
				//echo $cc->getSelect()->__toString();
				
				foreach ($collection->getItems() as $item) {				
				
					$row->setPaynearmeTotal($item->getTotalPaid());
					//return $item->getC();
				
				}
				
				return $cc->count();
			
			break;
			
			case "paylater":
				
				$collection->addFieldToFilter('`sales/order_payment`.method',array('eq'=>'paylater'));
				
				$cc->addFieldToFilter('`sales/order_payment`.method',array('eq'=>'paylater'));
				
				foreach ($collection->getItems() as $item) {				
				
					$row->setPaylaterTotal($item->getTotalPaid());
					//return $item->getC();
				
				}
				
				return $cc->count();
			
			break;
					
		}
	
	}	
		/*
$params = Mage::helper('adminhtml')->prepareFilterString(Mage::app()->getRequest()->getParam('filter'));
		
		//print_r($params); exit();
		
		$value =  $row->getData($this->getColumn()->getIndex());		
	
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
*/

		return '';

	}


}