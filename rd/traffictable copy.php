<?php


foreach ($dates as $dArr) {
		
		
		$data = $api->data($idg, '', 'ga:visits,ga:pageviews,ga:newVisits,ga:visitors', false, $dArr['start'], $dArr['end'], 1000000, 1, $filters);
		
		$visitorCount = $data['ga:visitors'];
				
		$q = "select count(*) as calls from sales_flat_quote where ppmd_rep != 99 and created_at >= '".$dArr['start']." 00:06:00' and created_at <= '".$dArr['end']." 00:06:00';";	
			
		$sth = $db->prepare($q);
		$sth->setFetchMode(Zend_Db::FETCH_ASSOC);
		$sth->execute();
		
		$res = $sth->fetchAll();
		
		
		$arr[implode("-",$dArr)]['calls'] = $res[0]['calls'];
		$arr[implode("-",$dArr)]['online'] = $visitorCount;
		$arr[implode("-",$dArr)]['total'] = $res[0]['calls']+$visitorCount;
		
	}
		echo "<pre>";
		print_r($arr); 
		echo "</pre>";
	
		
	makeTable($arr,"Traffic");
	
	$arr = array();

?>