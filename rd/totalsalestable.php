<?php

$group = $filter[$_GET['group']];

$totalOnlineSales = 0;

$totalPhoneSales = 0;

$ppmdRep = $_GET['ppmd_rep'];

$ppmdAff = $_GET['ppmd_affiliate'];

foreach ($group as $dArr) {
					
		$q = "select count(*) as sales from sales_flat_order as a join sales_flat_order_payment as b on b.parent_id = a.entity_id where a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00' and b.method = 'authorizenet';";	
		
		$q = "select count(*) as sales from sales_flat_order as a join sales_flat_order_payment as b on b.parent_id = a.entity_id where"; 
		
		if ($ppmdRep != "") {
	
			$q .= " a.ppmd_rep = ".$ppmdRep." and";
	
		}
		
		if ($ppmdAff != "") {
	
			$q .= " a.ppmd_affiliate = '".$ppmdAff."' and";
	
		} 
		
		$q .= " a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00' and b.method = 'authorizenet';";
									
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
				
		$arr[implode("-",$dArr)]['PN'] = $res[0]['sales'];
				
		$q = "select count(*) as sales from sales_flat_order as a join sales_flat_order_payment as b on b.parent_id = a.entity_id where a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00' and b.method = 'paylater';";	
							
		$q = "select count(*) as sales from sales_flat_order as a join sales_flat_order_payment as b on b.parent_id = a.entity_id where";
		
		if ($ppmdRep != "") {
	
			$q .= " a.ppmd_rep = ".$ppmdRep." and";
	
		}
		
		if ($ppmdAff != "") {
	
			$q .= " a.ppmd_affiliate = '".$ppmdAff."' and";
	
		}
		
		$q .= " a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00' and b.method = 'paylater';";	
							
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
		
		$arr[implode("-",$dArr)]['PL'] = $res[0]['sales'];
				
		$q = "select count(*) as sales from sales_flat_order as a join sales_flat_order_payment as b on b.parent_id = a.entity_id where a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00' and b.method = 'paynearme';";	
		
		$q = "select count(*) as sales from sales_flat_order as a join sales_flat_order_payment as b on b.parent_id = a.entity_id where";
		
		if ($ppmdRep != "") {
	
			$q .= " a.ppmd_rep = ".$ppmdRep." and";
	
		}
		
		if ($ppmdAff != "") {
	
			$q .= " a.ppmd_affiliate = '".$ppmdAff."' and";
	
		}
		
		$q .= " a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00' and b.method = 'paynearme';";
							
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
		
		$arr[implode("-",$dArr)]['PC'] = $res[0]['sales'];
				
		$q = "select count(*) as sales from sales_flat_order where created_at >= '".$dArr['start']." 06:00:00' and created_at <= '".$dArr['end']." 06:00:00' and ppmd_rep != 99;";	
		
		$q = "select count(*) as sales from sales_flat_order where";
		
		if ($ppmdRep != "") {
	
			$q .= " ppmd_rep = ".$ppmdRep." and";
	
		} else {
	
			$q .= " ppmd_rep != 99 and";
	
		}
		
		if ($ppmdAff != "") {
	
			$q .= " ppmd_affiliate = '".$ppmdAff."' and";
	
		}
		
		$q .= " created_at >= '".$dArr['start']." 06:00:00' and created_at <= '".$dArr['end']." 06:00:00';";
							
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
		
		$arr[implode("-",$dArr)]['Phn'] = $res[0]['sales'];
		
		$totalPhoneSales = $totalPhoneSales + $res[0]['sales'];
		
		$q = "select count(*) as sales from sales_flat_order where created_at >= '".$dArr['start']." 06:00:00' and created_at <= '".$dArr['end']." 06:00:00' and ppmd_rep = 99;";	
		
		$q = "select count(*) as sales from sales_flat_order where";
		
		/*
if ($ppmdRep != "") {
	
			$q .= " ppmd_rep = ".$ppmdRep." and";
	
		} else {
*/
	
			$q .= " ppmd_rep = 99 and";
	
		//}
		
		if ($ppmdAff != "") {
	
			$q .= " ppmd_affiliate = '".$ppmdAff."' and";
	
		}
		
		$q .= " created_at >= '".$dArr['start']." 06:00:00' and created_at <= '".$dArr['end']." 06:00:00';";	
							
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
		
		$arr[implode("-",$dArr)]['Onl'] = $res[0]['sales'];
		
		$totalOnlineSales = $totalOnlineSales + $res[0]['sales'];
						
	}
	
?>

	<div style="float:left;">
	
<?php
		
	makeTable($arr,"&nbsp;","Total Sales",5,0,1);
	
?>

	</div>
	
<?php
	
	$arr = array();

?>