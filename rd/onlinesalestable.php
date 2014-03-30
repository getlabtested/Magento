<?php

$group = $filter[$_GET['group']];

$ppmdRep = $_GET['ppmd_rep'];

$ppmdAff = $_GET['ppmd_affiliate'];

//echo $ppmdRep;

$totalSumOnlinePayNowSales = 0;

foreach ($group as $dArr) {
	
				
		$q = "select count(*) as sales from sales_flat_order as a left join sales_flat_order_payment as b on b.parent_id = a.entity_id where a.ppmd_rep = 99 and a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00' and b.method = 'authorizenet';";	
		
		$q = "select count(*) as sales from sales_flat_order as a left join sales_flat_order_payment as b on b.parent_id = a.entity_id where"; 
		
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
		
		$q .= " a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00' and b.method = 'authorizenet';";
															
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
				
		$arr[implode("-",$dArr)]['PN'] = $res[0]['sales'];
		
		$totalSumOnlinePayNowSales = $totalSumOnlinePayNowSales + $res[0]['sales'];
		
		$q = "select count(*) as sales from sales_flat_order as a left join sales_flat_order_payment as b on b.parent_id = a.entity_id where a.ppmd_rep = 99 and a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00' and b.method = 'paynearme';";	
		
		$q = "select count(*) as sales from sales_flat_order as a left join sales_flat_order_payment as b on b.parent_id = a.entity_id where";
		
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
		
		$q .= " a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00' and b.method = 'paynearme';";
											
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
		
		$arr[implode("-",$dArr)]['PC'] = $res[0]['sales'];
				
				
	}
	
?>

	<div style="float:left;">
	
<?php
		
	makeTable($arr,"&nbsp;","Online Sales",2,0,1);
	
	
?>

	</div>
	
<?php
	
	$arr = array();

?>