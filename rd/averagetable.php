<?php

$group = $filter[$_GET['group']];

$ppmdRep = $_GET['ppmd_rep'];

$ppmdAff = $_GET['ppmd_affiliate'];

foreach ($group as $dArr) {
				
		$q = "select AVG(grand_total) as sales from sales_flat_order where";
		
		if ($ppmdRep != "") {
	
			$q .= " ppmd_rep = ".$ppmdRep." and";
	
		} else {
	
			$q .= " ppmd_rep != 99 and";
	
		}
		
		if ($ppmdAff != "") {
	
			$q .= " ppmd_affiliate = '".$ppmdAff."' and";
	
		}
		
		$q .= " created_at >= '".$dArr['start']." 06:00:00' and product_line < 2 and created_at <= '".$dArr['end']." 06:00:00';";	
									
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
				
		$arr[implode("-",$dArr)]['Phone'] = round($res[0]['sales']);
		
		$q = "select AVG(grand_total) as sales from sales_flat_order where";
		
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
		
		$q .= " created_at >= '".$dArr['start']." 06:00:00' and product_line < 2 and created_at <= '".$dArr['end']." 06:00:00';";	
									
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
				
		$arr[implode("-",$dArr)]['Online'] = round($res[0]['sales']);
						
		$q = "select AVG(grand_total) as sales from sales_flat_order where";
		
		if ($ppmdRep != "") {
	
			$q .= " ppmd_rep = ".$ppmdRep." and";
	
		} 
		
		if ($ppmdAff != "") {
	
			$q .= " ppmd_affiliate = '".$ppmdAff."' and";
	
		}
		
		$q .= " created_at >= '".$dArr['start']." 06:00:00' and created_at <= '".$dArr['end']." 06:00:00' and product_line < 2;";	
									
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
		
		$arr[implode("-",$dArr)]['Total'] = round($res[0]['sales']);
				
	}
	
	
?>

	<div style="float:left;">
	
<?php
		
	makeTable($arr,"&nbsp;","Averages",3,0,2);
	
?>

	</div>
	
<?php
	
	$arr = array();

?>