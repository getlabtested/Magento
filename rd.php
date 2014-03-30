<?php
ini_set("memory_limit","-1"); ini_set('auto_detect_line_endings', true);
ini_set("display_errors",1);
date_default_timezone_set('America/Los_Angeles');

$storeId = 2;

require 'app/Mage.php';

if (!Mage::isInstalled()) {
   echo "Application is not installed yet, please complete install wizard first.";
   exit;
}

$_SERVER['SCRIPT_NAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_NAME']);
$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_FILENAME']);

Mage::app();
Mage::app()->setCurrentStore($storeId);

$storeCode = Mage::getModel('core/store')->load($storeId)->getCode(); 
$websiteId = Mage::getModel('core/store')->load($storeId)->getWebsiteId();
$websiteCode = Mage::getModel('core/website')->load($websiteId)->getCode();

$config  = Mage::getConfig()->getResourceConnectionConfig("default_setup");

$tv = 1488;

$date = date('Y-m-d',time());

$yesterday = date('Y-m-d',strtotime("-1 day"));

$lastSunday = date('Y-m-d',strtotime("last sunday, 12:01AM"));

$twoSundaysAgoTs = strtotime("last sunday, 12:01AM");

$twoSundaysAgo = date('Y-m-d',$twoSundaysAgoTs-(60*60*24*7));

$curMonth = date('Y-m',time());

$lastMonthTs = mktime(0,0,0,date('m',time())-1,1,date('y',time()));

$lastMonth = date('Y-m',$lastMonthTs);
        
$db = new PDO ('mysql:dbname='.$config->dbname.';host='.$config->host, $config->username, $config->password);

?>
<style>
body {
	font-family:  Arial, Verdana, Helvetica, sans-serif;
	font-size: 11px;
}

a {
	color: #464646;
}

a:hover {
	color: #00C;	
}

.reportTitle {
	color:#DF6323;
  font-size:16pt;
  font-weight:bold;	
}

table
{
  cellspacing:0px;
  cellpadding:0px;
  font-family:  Arial, Verdana, Helvetica, sans-serif;
  font-size: 11px;  
}

td {text-align:center;padding-right:2px;padding-left:2px}
#totalCol {background-color:"#F9E1D5"}
#leftBorder {border-left:2px solid black};
#rightBorder {border-right:2px solid black};
#topBorder {border-top:2px solid black};
#bottomBorder {border-bottom:1px solid black};
</style>
<?php



	


include "rd/today.php";
echo "<br><br>";
include "rd/yesterday.php";
echo "<br><br>";
include "rd/thisweek.php";
echo "<br><br>";
include "rd/lastweek.php";
echo "<br><br>";
include "rd/currentmonth.php";
echo "<br><br>";
include "rd/lastmonth.php";
        
    
    
    
    
    
    
    
    
    
    
    
    