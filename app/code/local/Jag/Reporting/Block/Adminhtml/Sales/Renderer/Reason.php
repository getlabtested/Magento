<?php

class Jag_Reporting_Block_Adminhtml_Sales_Renderer_Reason extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
	$value =  $this->getColumn()->getIndex();
	
	$params = Mage::helper('adminhtml')->prepareFilterString(Mage::app()->getRequest()->getParam('filter'));
		
	if ($params['created_at'] && is_array($params['created_at'])) {
	
		$from = $params['created_at']['from'];
		
		$from = date('Y-m-d',strtotime($from));
		
		$to = $params['created_at']['to'];
		
		$to = date('Y-m-d',strtotime($to));
	
		$collection = Mage::getModel('sales/quote')->getCollection();
		$collection->addFieldToSelect('entity_id');
		$collection->addFieldToFilter('affiliate_id',array('eq'=>$row->getAffiliateId()));
		$collection->addFieldToFilter('ppmd_rep',array('neq'=>99));
		$collection->addFieldToFilter('created_at',array('gt'=>$from));
		$collection->addFieldToFilter('created_at',array('lt'=>$to));
		
		
		
				$reas[4]="Serious Interest";
                $reas[6]="Wrong Number";
              	$reas[7]="Hang-up";
              	$reas[1]="Customer Service/Counseling";
              	$reas[3]="General Inquiry / STD Information";
              	$reas[2]="Free Testing";
              	$reas[5]="Tests Not Offered";
            	$reas[8]="Solicitation";
		
		switch ($value) {
		
			case "serious_interest":
				
				$collection->addFieldToFilter('ppmd_call_reason',array('eq'=>4));
				
				//echo $collection->getSelect()->__toString(); exit();
				return $collection->count();
			
			break;
			
			case "customer_service":
				
				$collection->addFieldToFilter('ppmd_call_reason',array('eq'=>1));
								
				return $collection->count();
			
			break;
			
			case "free_testing":
				
				$collection->addFieldToFilter('ppmd_call_reason',array('eq'=>2));
				
					return $collection->count();	
			
			break;
			
			case "general_inquiry":
				
				$collection->addFieldToFilter('ppmd_call_reason',array('eq'=>3));
				
					return $collection->count();	
			
			break;
			
			case "wrong_number":
				
				$collection->addFieldToFilter('ppmd_call_reason',array('eq'=>6));
								
				return $collection->count();
			
			break;
			
			case "test_not_offered":
				
				$collection->addFieldToFilter('ppmd_call_reason',array('eq'=>5));
								
				return $collection->count();
			
			break;
			
			case "hang_up":
				
				$collection->addFieldToFilter('ppmd_call_reason',array('eq'=>7));
								
				return $collection->count();
			
			break;
			
			case "solicitation":
				
				$collection->addFieldToFilter('ppmd_call_reason',array('eq'=>8));
					
				return $collection->count();
			
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