<?php

$group = $filter[$_GET['group']];

$totalSumOnlinePayNowSales = 0;
$totalSumOnlineSales = 0;

$ppmdRep = $_GET['ppmd_rep'];

$ppmdAff = $_GET['ppmd_affiliate'];

foreach ($group as $dArr) {

		if ($_GET['group'] == 'dates') {
		
	$data = $api->data($idg, '', 'ga:visits,ga:pageviews,ga:newVisits,ga:visitors', false, $dArr['start'], $dArr['start'], 1000000, 1, $filters);
	
	} else {
	
		$data = $api->data($idg, '', 'ga:visits,ga:pageviews,ga:newVisits,ga:visitors', false, $dArr['start'], $dArr['end'], 1000000, 1, $filters);
	
	}
	
	$pc = $data['ga:visitors'];
				
		$q = "select count(*) as sales from sales_flat_order as a join sales_flat_order_payment as b on b.parent_id = a.entity_id where";
		
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
				
		$totalOnlinePayNowSales = $res[0]['sales'];
		
		$totalSumOnlinePayNowSales = $totalSumOnlinePayNowSales + $res[0]['sales'];
		
		$arr[implode("-",$dArr)]['PN'] = round(($totalOnlinePayNowSales/$pc)*100,2);
						
		$q = "select count(*) as sales from sales_flat_order as a join sales_flat_order_payment as b on b.parent_id = a.entity_id where";
		
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
				
		$totalOnlinePayCashSales = $res[0]['sales'];
		
		$totalSumOnlineSales = $totalSumOnlineSales + $totalOnlinePayNowSales + $totalOnlinePayCashSales;
								
		$arr[implode("-",$dArr)]['Total'] = round((($totalOnlinePayNowSales+$totalOnlinePayCashSales)/$pc)*100,2);
				
	}
	
?>

	<div style="float:left;">
	
<?php
			
	makeTable($arr,"&nbsp;","Online Conv",2,0,2,$totalSumOnlinePayNowSales,$totalSumOnlineSales,$totalOnlineVisits);
	
?>

	</div>
	
<?php
	
	$arr = array();

?>