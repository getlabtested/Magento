<?php

$group = $filter[$_GET['group']];

	$totalOnlineVisits = 0;
	$totalCallVisits = 0;
	$totalVisits = 0;
	
$ppmdRep = $_GET['ppmd_rep'];

$ppmdAff = $_GET['ppmd_affiliate'];
	
foreach ($group as $dArr) {

	if ($_GET['group'] == 'dates') {
		
	$data = $api->data($idg, '', 'ga:visits,ga:pageviews,ga:newVisits,ga:visitors', false, $dArr['start'], $dArr['start'], 1000000, 1, $filters);
	
	
	} else {
	
		$data = $api->data($idg, '', 'ga:visits,ga:pageviews,ga:newVisits,ga:visitors', false, $dArr['start'], $dArr['end'], 1000000, 1, $filters);

			
	}
	
	$visitorCount = $data['ga:visitors'];
				
	$q = "select count(*) as calls from sales_flat_quote where";
	
	if ($ppmdRep != "") {
	
		$q .= " ppmd_rep = ".$ppmdRep." and ";
	
	} else {
	
		$q .= " ppmd_rep != 99 and";
	
	}
	
	if ($ppmdAff != "") {
	
			$q .= " ppmd_affiliate = '".$ppmdAff."' and";
	
	} 

	
	$q.= " created_at >= '".$dArr['start']." 06:00:00' and created_at <= '".$dArr['end']." 06:00:00';";	
		
	$sth = $db->prepare($q);
	$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
	$sth->execute();
	
	$res = $sth->fetchAll();
	
	$arr[implode("-",$dArr)]['calls'] = $res[0]['calls'];
	
	$arr[implode("-",$dArr)]['online'] = $visitorCount;
	
	//$arr[implode("-",$dArr)]['total'] = $res[0]['calls']+$visitorCount;
		
	$totalOnlineVisits = $totalOnlineVisits + $visitorCount;
	$totalCallVisits = $totalCallVisits + $res[0]['calls'];
		
}

	
?>

	<div style="float:left;">
	
<?php
		
	makeTable($arr,"&nbsp;","Traffic",4,1,1,null,null,null,1);
	
?>

	</div>
	
<?php
	
	$arr = array();

?>