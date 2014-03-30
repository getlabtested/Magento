<?php
	
	$_GET['group'] = 'weeks';
	//$dates = getDays($startGa,$endGa);
	$weeks = getWeeks($startGa,$endGa);
	//$months = getMonths($startGa,$endGa);
	
	$filter['dates'] = $dates;
	$filter['weeks'] = $weeks;
	$filter['months'] = $months;
	
	$arr = array();
	
echo "<div id='tables' style='min-width:1300px;clear:both;'>";
	
	include('/home/webapps/sites/magento/public/rd/traffictable.php');
	
	include('/home/webapps/sites/magento/public/rd/phonesalestable.php');
	
	include('/home/webapps/sites/magento/public/rd/onlinesalestable.php');
	
	include('/home/webapps/sites/magento/public/rd/totalsalestable.php');
	
	include('/home/webapps/sites/magento/public/rd/phoneconversiontable.php');
	
	include('/home/webapps/sites/magento/public/rd/onlineconversiontable.php');
	
	include('/home/webapps/sites/magento/public/rd/averagetable.php');
	
	include('/home/webapps/sites/magento/public/rd/revenuetable.php');
	
	
	
echo "</div>";	

echo "<br>";
	
	
?>
<div style="height:10px;clear:both;">&nbsp;<br></div>