<?php

class Jag_Reporting_Block_Adminhtml_Rep_Renderer_Totalsales extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
		$config  = Mage::getConfig()->getResourceConnectionConfig("default_setup");
	
		$db = new PDO('mysql:dbname='.$config->dbname.';host='.$config->host, $config->username, $config->password);
	
		$rep = $row->getPpmdRep();
				
		$params = Mage::helper('adminhtml')->prepareFilterString(Mage::app()->getRequest()->getParam('filter'));
		
		if ($params['created_at'] && is_array($params['created_at'])) {
		
			$from = $params['created_at']['from'];
			
			$from = date('Y-m-d',strtotime($from));
			
			$to = $params['created_at']['to'];
			
			$to = date('Y-m-d',strtotime($to));
	
			$q = 'select SUM(a.grand_total) as total_paid,SUM(a.base_total_refunded) as total_ref from sales_flat_invoice as a join sales_flat_order as b on b.entity_id = a.order_id where b.ppmd_rep = '.$rep .' and a.updated_at >= "'.$from.'" and a.updated_at <= "'.$to.'";';
									
			$sth = $db->prepare($q);
			$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
			$sth->execute();
			
			$res = $sth->fetchAll();
	   		   		   		   		   		
			$s = $res[0]['total_paid'];
			$r = $res[0]['total_ref'];
	   			   		
	   		   		
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
	   		
	   		$c = $row->getTotalPaynow()+$row->getTotalPaynearme()+$row->getTotalPaylater();
	   		
	   		$con = ($c/$row->getTotalCalls())*100;
	   		
	   		$row->setTotalSalesCount($c);
	   		
	   		$row->setConversion(round($con,2).'%');
	   						
			return $c;
		
		}

	}


}