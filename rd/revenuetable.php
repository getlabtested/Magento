<?php

$group = $filter[$_GET['group']];

$ppmdRep = $_GET['ppmd_rep'];

$ppmdAff = $_GET['ppmd_affiliate'];

foreach ($group as $dArr) {
	
		$q = "select SUM(grand_total) as sales from sales_flat_order as a join sales_flat_order_payment as b on b.parent_id = a.entity_id  where a.ppmd_rep != 99 and a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00' and a.product_line < 2 and b.method = 'authorizenet';";	
		
		$q = "select SUM(grand_total) as sales from sales_flat_order as a join sales_flat_order_payment as b on b.parent_id = a.entity_id  where";
		
		if ($ppmdRep != "") {
	
			$q .= " a.ppmd_rep = ".$ppmdRep." and";
	
		} else {
	
			$q .= " a.ppmd_rep != 99 and";
	
		}
		
		if ($ppmdAff != "") {
	
			$q .= " a.ppmd_affiliate = '".$ppmdAff."' and";
	
		}
		
		$q .= " a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00' and a.product_line < 2 and b.method = 'authorizenet';";
									
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
				
		$arr[implode("-",$dArr)]['Phone'] = round($res[0]['sales']);
		
		$q = "select SUM(grand_total) as sales from sales_flat_order as a join sales_flat_order_payment as b on b.parent_id = a.entity_id  where a.ppmd_rep = 99 and a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00' and a.product_line < 2 and b.method = 'authorizenet';";	
		
		$q = "select SUM(grand_total) as sales from sales_flat_order as a join sales_flat_order_payment as b on b.parent_id = a.entity_id  where";
		
		/*
if ($ppmdRep != "") {
	
			$q .= " a.ppmd_rep = ".$ppmdRep." and";
	
		} else {
*/
	
			$q .= " a.ppmd_rep = 99 and";
	
		//}
		
		if ($ppmdAff != "") {
	
			$q .= " a.ppmd_affiliate = '".$ppmdAff."' and";
	
		}
		
		$q .= " a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00' and a.product_line < 2 and b.method = 'authorizenet';";
									
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
				
		$arr[implode("-",$dArr)]['Online'] = round($res[0]['sales']);
		
		$q = "select IFNULL(SUM(grand_total),0) as sales from sales_flat_order where product_line > 1 and status='complete' and created_at >= '".$dArr['start']." 06:00:00' and created_at <= '".$dArr['end']." 06:00:00';";	
		
		$q = "select IFNULL(SUM(grand_total),0) as sales from sales_flat_order where";
		
		if ($ppmdRep != "") {
	
			$q .= " ppmd_rep = ".$ppmdRep." and";
	
		}
				
		if ($ppmdAff != "") {
	
			$q .= " ppmd_affiliate = '".$ppmdAff."' and";
	
		}
		
		$q .= " product_line > 1 and status='complete' and created_at >= '".$dArr['start']." 06:00:00' and created_at <= '".$dArr['end']." 06:00:00';";
									
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
				
		$arr[implode("-",$dArr)]['Script'] = round($res[0]['sales']);
		
		$q = "select SUM(a.grand_total) as sales from sales_flat_invoice as a join sales_flat_order_payment as b on b.parent_id = a.order_id where b.method = 'paylater' and a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00';";	
		$q = "select SUM(a.grand_total) as sales from sales_flat_invoice as a join sales_flat_order_payment as b on b.parent_id = a.order_id join sales_flat_order as c on c.entity_id = a.order_id where";
		
		if ($ppmdRep != "") {
	
			$q .= " c.ppmd_rep = ".$ppmdRep." and";
	
		} 
		
		if ($ppmdAff != "") {
	
			$q .= " c.ppmd_affiliate = '".$ppmdAff."' and";
	
		}

		
		$q .= " b.method = 'paylater' and a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00';";
									
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
				
		$arr[implode("-",$dArr)]['PL'] = round($res[0]['sales']);
		
		$q = "select SUM(a.grand_total) as sales from sales_flat_invoice as a join sales_flat_order_payment as b on b.parent_id = a.order_id where b.method = 'paynearme' and a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00';";	
		
		$q = "select SUM(a.grand_total) as sales from sales_flat_invoice as a join sales_flat_order_payment as b on b.parent_id = a.order_id join sales_flat_order as c on c.entity_id = a.order_id where";
		
		if ($ppmdRep != "") {
	
			$q .= " c.ppmd_rep = ".$ppmdRep." and";
	
		} 
		
		if ($ppmdAff != "") {
	
			$q .= " c.ppmd_affiliate = '".$ppmdAff."' and";
	
		}

		
		$q .= " b.method = 'paynearme' and a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00';";
									
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
				
		$arr[implode("-",$dArr)]['PC'] = round($res[0]['sales']);
		
		$q = "select IFNULL(SUM(base_total_refunded),0) as sales from sales_flat_invoice where updated_at >= '".$dArr['start']." 06:00:00' and updated_at <= '".$dArr['end']." 06:00:00';";	
		
		$q = "select IFNULL(SUM(a.base_total_refunded),0) as sales from sales_flat_invoice as a join sales_flat_order as b on b.entity_id = a.order_id where";
		
		if ($ppmdRep != "") {
	
			$q .= " b.ppmd_rep = ".$ppmdRep." and";
	
		} 
		
		if ($ppmdAff != "") {
	
			$q .= " b.ppmd_affiliate = '".$ppmdAff."' and";
	
		}
		
		$q .= " a.updated_at >= '".$dArr['start']." 06:00:00' and a.updated_at <= '".$dArr['end']." 06:00:00';";
									
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
				
		$arr[implode("-",$dArr)]['Ref'] = round($res[0]['sales']);
		
		$q = "select SUM(grand_total) as sales from sales_flat_order where created_at >= '".$dArr['start']." 06:00:00' and created_at <= '".$dArr['end']." 06:00:00';";	
		
		$q = "select SUM(grand_total) as sales from sales_flat_order where";
		
		if ($ppmdRep != "") {
	
			$q .= " ppmd_rep = ".$ppmdRep." and";
	
		} 
				
		if ($ppmdAff != "") {
	
			$q .= " ppmd_affiliate = '".$ppmdAff."' and";
	
		}
		
		$q .= " created_at >= '".$dArr['start']." 06:00:00' and created_at <= '".$dArr['end']." 06:00:00';";	
									
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
				
		$arr[implode("-",$dArr)]['Sales'] = round($res[0]['sales']);
		
		$q = "select SUM(grand_total) as sales from sales_flat_invoice where created_at >= '".$dArr['start']." 06:00:00' and created_at <= '".$dArr['end']." 06:00:00';";	
		
		$q = "select SUM(a.grand_total) as sales from sales_flat_invoice as a join sales_flat_order as b on b.entity_id = a.order_id where";
		
		if ($ppmdRep != "") {
	
			$q .= " b.ppmd_rep = ".$ppmdRep." and";
	
		} 
		
		if ($ppmdAff != "") {
	
			$q .= " b.ppmd_affiliate = '".$ppmdAff."' and";
	
		}
		
		$q .= " a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00';";	
									
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
				
		//$arr[implode("-",$dArr)]['Paid'] = round($res[0]['sales']);
		
		$paid = round($res[0]['sales']);
		
		
		//$arr[implode("-",$dArr)]['Cash'] = $arr[implode("-",$dArr)]['Paid']-$arr[implode("-",$dArr)]['Ref'];
		
		$arr[implode("-",$dArr)]['Cash'] = $paid - $arr[implode("-",$dArr)]['Ref'];
				
	}
	
?>

	<div style="float:left;">
	
<?php
		
	makeTable($arr,"&nbsp;","Revenue",9,0,1);
	
?>

	</div>
	
<?php
	
	$arr = array();

?>