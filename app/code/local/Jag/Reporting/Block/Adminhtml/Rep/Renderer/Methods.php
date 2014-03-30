<?php

class Jag_Reporting_Block_Adminhtml_Rep_Renderer_Methods extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row) {
	
	$value =  $this->getColumn()->getIndex();
	
	$rep = $row->getPpmdRep();
	
	$params = Mage::helper('adminhtml')->prepareFilterString(Mage::app()->getRequest()->getParam('filter'));
		
	$config  = Mage::getConfig()->getResourceConnectionConfig("default_setup");
	
	$db = new PDO('mysql:dbname='.$config->dbname.';host='.$config->host, $config->username, $config->password);
		
		//echo "here"; exit();
		
	
	if ($params['created_at'] && is_array($params['created_at'])) {
	
		$from = $params['created_at']['from'];
		
		$from = date('Y-m-d',strtotime($from));
		
		$to = $params['created_at']['to'];
		
		$to = date('Y-m-d',strtotime($to));
		
		//echo $collection->getSelect()->__toString(); exit();
		
		switch ($value) {
		
			case "authorizenet":
			
				$r = "";
				
				$q = 'select count(*) as tc,SUM(c.grand_total) as total_paid from sales_flat_order_payment as a join sales_flat_order as b on b.entity_id = a.parent_id left join sales_flat_invoice as c on c.order_id = b.entity_id where a.method = "authorizenet" and b.ppmd_rep = '.$rep .' and b.created_at >= "'.$from.'" and b.created_at <= "'.$to.'";';
								
				$sth = $db->prepare($q);
				$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
    			$sth->execute();
    			
    			$r = $sth->fetchAll();
				
				$row->setPaynowTotal($r[0]['total_paid']);
				$row->setTotalPaynow($r[0]['tc']);
				
				return $r[0]['tc'];				
			
			break;
			
			case "paynearme":
			
				$r = "";
				
				$q = 'select count(*) as tc,SUM(c.grand_total) as total_paid from sales_flat_order_payment as a join sales_flat_order as b on b.entity_id = a.parent_id left join sales_flat_invoice as c on c.order_id = b.entity_id where a.method = "paynearme" and b.ppmd_rep = '.$rep .' and b.created_at >= "'.$from.'" and b.created_at <= "'.$to.'";';
								
				//echo $q; exit();
								
				$sth = $db->prepare($q);
				$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
    			$sth->execute();
    			
    			$r = $sth->fetchAll();
				
				$row->setPaynearmeTotal($r[0]['total_paid']);
				$row->setTotalPaynearme($r[0]['tc']);
				
				return $r[0]['tc'];	
			
			break;
			
			case "paylater":
			
				$r = "";
				
				$q = 'select count(*) as tc,SUM(c.grand_total) as total_paid from sales_flat_order_payment as a join sales_flat_order as b on b.entity_id = a.parent_id left join sales_flat_invoice as c on c.order_id = b.entity_id where a.method = "paylater" and b.ppmd_rep = '.$rep .' and b.created_at >= "'.$from.'" and b.created_at <= "'.$to.'";';
								
				$sth = $db->prepare($q);
				$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
    			$sth->execute();
    			
    			$r = $sth->fetchAll();
				
				$row->setPaylaterTotal($r[0]['total_paid']);
				$row->setTotalPaylater($r[0]['tc']);
				
				return $r[0]['tc'];	
			
			break;
					
		}
	
	}	

		return '';

	}


}