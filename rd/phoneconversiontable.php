<?php

$group = $filter[$_GET['group']];

$totalSumPhonePayNowSales = 0;

$totalSumPhoneSales = 0;

$ppmdRep = $_GET['ppmd_rep'];

$ppmdAff = $_GET['ppmd_affiliate'];

foreach ($group as $dArr) {

		$q = "select count(*) as calls from sales_flat_quote where";
		
		if ($ppmdRep != "") {
	
			$q .= " ppmd_rep = ".$ppmdRep." and";
	
		} else {
	
			$q .= " ppmd_rep != 99 and";
	
		}
		
		if ($ppmdAff != "") {
	
			$q .= " ppmd_affiliate = '".$ppmdAff."' and";
	
		}
		
		$q .= " created_at >= '".$dArr['start']." 06:00:00' and created_at <= '".$dArr['end']." 06:0:00';";	
			
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
		
		$pc = $res[0]['calls'];
			
		$q = "select count(*) as sales from sales_flat_order as a join sales_flat_order_payment as b on b.parent_id = a.entity_id where";
		
		if ($ppmdRep != "") {
	
			$q .= " a.ppmd_rep = ".$ppmdRep." and";
	
		} else {
	
			$q .= " a.ppmd_rep != 99 and";
	
		}
		
		if ($ppmdAff != "") {
	
			$q .= " a.ppmd_affiliate = '".$ppmdAff."' and";
	
		}
		
		$q .= " a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00' and b.method = 'authorizenet';";	
							
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
				
		$totalPhonePayNowSales =  $res[0]['sales'];
		
		$totalSumPhonePayNowSales = $totalSumPhonePayNowSales + $res[0]['sales'];
		
		$arr[implode("-",$dArr)]['PN'] = round(($totalPhonePayNowSales/$pc)*100,2);
				
		$q = "select count(*) as sales from sales_flat_order as a join sales_flat_order_payment as b on b.parent_id = a.entity_id where";
		
		if ($ppmdRep != "") {
	
			$q .= " a.ppmd_rep = ".$ppmdRep." and";
	
		} else {
	
			$q .= " a.ppmd_rep != 99 and";
	
		}
		
		if ($ppmdAff != "") {
	
			$q .= " a.ppmd_affiliate = '".$ppmdAff."' and";
	
		}
		
		$q .= " a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00' and b.method = 'paylater';";	
							
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
				
		$totalPhonePayLaterSales = $res[0]['sales'];
		
		$q = "select count(*) as sales from sales_flat_order as a join sales_flat_order_payment as b on b.parent_id = a.entity_id where";
		
		if ($ppmdRep != "") {
	
			$q .= " a.ppmd_rep = ".$ppmdRep." and";
	
		} else {
	
			$q .= " a.ppmd_rep != 99 and";
	
		}
		
		if ($ppmdAff != "") {
	
			$q .= " a.ppmd_affiliate = '".$ppmdAff."' and";
	
		}
		
		$q .= " a.created_at >= '".$dArr['start']." 06:00:00' and a.created_at <= '".$dArr['end']." 06:00:00' and b.method = 'paynearme';";
		
							
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
				
		$totalPhonePayCashSales = $res[0]['sales'];
		
		$totalSumPhoneSales = $totalSumPhoneSales + $totalPhonePayNowSales + $totalPhonePayLaterSales + $totalPhonePayCashSales;
								
		$arr[implode("-",$dArr)]['Total'] = round((($totalPhonePayNowSales+$totalPhonePayLaterSales+$totalPhonePayCashSales)/$pc)*100,2);
				
	}
	
?>

	<div style="float:left;">
	
<?php
			
	makeTable($arr,"&nbsp;","Phone Conv",2,0,2,$totalSumPhonePayNowSales,$totalSumPhoneSales,$totalCallVisits);
	
?>

	</div>
	
<?php
	
	$arr = array();

?>