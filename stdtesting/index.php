<?php
if (isset($_SERVER["SERVER_NAME"]) && (strpos($_SERVER["SERVER_NAME"], "getlabtested.com") !== FALSE))
{
    header("Location: http://getlabtested.com/custom-404");
    exit;
}

include('includes/config.inc.php');
include('includes/db.inc.php');
include('includes/functions.inc.php');

connection();

// somethign like the base url
//$urlForLinks = $_SERVER['SVR_NAME'].'/stdtesting/';
$urlForLinks = 'http://getstdtested.com/stdtesting/';

//Remove request parameters:
list($path) = explode('?', $_SERVER['REQUEST_URI']);

//Explode path to directories and remove empty items:
$pathInfo = array();
foreach (explode('/', $path) as $dir) {
  if (!empty($dir)) {
    $pathInfo[] = urldecode($dir);
  }
}

if (count($pathInfo) > 0) {
	// std-testing-in-<state>
	// std-testing-in-<state>-<city>
	// std-testing-in-<state>-<city>-<location>

	// <state>-std-testing
	// <state>-<city>-std-testing
	// <state>-<city>-<location>-std-testing
	
	// std-screening-in-<state>
	// std-screening-in-<state>-<city>
	// std-screening-in-<state>-<city>-<location>

	// <state>-std-screening
	// <state>-<city>-std-screening
	// <state>-<city>-<location>-std-screening
	
	$urlVariation1 = 'std-testing-in-';
	$urlVariation2 = '-std-testing';
	$urlVariation3 = 'std-screening-in-';
	$urlVariation4 = '-std-screening';
	
	$last = $pathInfo[count($pathInfo)-1];
	//echo "<span style='color:white'>".$last."</span><br />";
	$last = str_replace('std-testing-in-', '', $last);
	$last = str_replace('-std-testing', '', $last);
	$last = str_replace('std-screening-in-', '', $last);
	$last = str_replace('-std-screening', '', $last);
	//echo "<span style='color:white'>".$last."</span><br />";
	$pathInfo = array();
	foreach (explode('-', $last) as $dir) {
		if (!empty($dir)) $pathInfo[] = urldecode($dir);
	}
}

if ($pathInfo[0] != "stdtesting") {
	$state = $pathInfo[0];
	if (stateExists($state)) {
		if (isset($pathInfo[1])) $city = $pathInfo[1];
		if (isset($pathInfo[1]) && isset($pathInfo[2])) $city = $pathInfo[1]." ".$pathInfo[2];
		if (isset($pathInfo[1]) && isset($pathInfo[2]) && isset($pathInfo[3])) $city = $pathInfo[1]." ".$pathInfo[2]." ".$pathInfo[3];
		if (isset($pathInfo[1]) && isset($pathInfo[2]) && isset($pathInfo[3]) && isset($pathInfo[4])) $city = $pathInfo[1]." ".$pathInfo[2]." ".$pathInfo[3]." ".$pathInfo[4];
		if (isset($pathInfo[1]) && isset($pathInfo[2]) && isset($pathInfo[3]) && isset($pathInfo[4]) && isset($pathInfo[5])) $city = $pathInfo[1]." ".$pathInfo[2]." ".$pathInfo[3]." ".$pathInfo[4]." ".$pathInfo[5];
	} else {
		$state = $pathInfo[0]." ".$pathInfo[1];
		if (stateExists($state)) {
			if (isset($pathInfo[2])) $city = $pathInfo[2];
			if (isset($pathInfo[2]) && isset($pathInfo[3])) $city = $pathInfo[2]." ".$pathInfo[3];
			if (isset($pathInfo[2]) && isset($pathInfo[3]) && isset($pathInfo[4])) $city = $pathInfo[2]." ".$pathInfo[3]." ".$pathInfo[4];
			if (isset($pathInfo[2]) && isset($pathInfo[3]) && isset($pathInfo[4]) && isset($pathInfo[5])) $city = $pathInfo[2]." ".$pathInfo[3]." ".$pathInfo[4]." ".$pathInfo[5];
			if (isset($pathInfo[2]) && isset($pathInfo[3]) && isset($pathInfo[4]) && isset($pathInfo[5]) && isset($pathInfo[6])) $city = $pathInfo[2]." ".$pathInfo[3]." ".$pathInfo[4]." ".$pathInfo[5]." ".$pathInfo[6];
		} else {
			$state = $pathInfo[0]." ".$pathInfo[1]." ".$pathInfo[2];
			if (stateExists($state)) {
				if (isset($pathInfo[3])) $city = $pathInfo[3];
				if (isset($pathInfo[3]) && isset($pathInfo[4])) $city = $pathInfo[3]." ".$pathInfo[4];
				if (isset($pathInfo[3]) && isset($pathInfo[4]) && isset($pathInfo[5])) $city = $pathInfo[3]." ".$pathInfo[4]." ".$pathInfo[5];
				if (isset($pathInfo[3]) && isset($pathInfo[4]) && isset($pathInfo[5]) && isset($pathInfo[6])) $city = $pathInfo[3]." ".$pathInfo[4]." ".$pathInfo[5]." ".$pathInfo[6];
				if (isset($pathInfo[3]) && isset($pathInfo[4]) && isset($pathInfo[5]) && isset($pathInfo[6]) && isset($pathInfo[7])) $city = $pathInfo[3]." ".$pathInfo[4]." ".$pathInfo[5]." ".$pathInfo[6]." ".$pathInfo[7];
			} else unset($state);
		}
	}
}
if (isset($state)) $state = ucwords(strtolower($state));
if (isset($city)) $city = ucwords(strtolower($city));

if (isset($_POST['zipcode'])) $zip = $_POST['zipcode'];
if (isset($zip)) {
	$result = sql("SELECT DISTINCT id, City, State FROM zipcodes WHERE ZipCode='$zip' GROUP BY City ORDER BY City LIMIT 1;");
	
	if ((mysql_num_rows($result)) != "0") {
		$data = mysql_fetch_row($result);
		$city = strtolower($data[1]);
		$cityDashes = str_replace(' ', '-', $city);
		$state = strtolower(stateToFull($data[2]));
		$stateDashes = str_replace(' ', '-', $state);
		
		if ($data[0] % 4 == 0) { 
			$urlDestination = $urlForLinks.$stateDashes."-".$cityDashes.$urlVariation4;
		} else {
			if ($data[0] % 3 == 0) { 
				$urlDestination = $urlForLinks.$urlVariation3.$stateDashes."-".$cityDashes;
			} else {
				if ($data[0] % 2 == 0) { 
					$urlDestination = $urlForLinks.$stateDashes."-".$cityDashes.$urlVariation2;
				} else {
					if ($data[0] % 1 == 0) { 
						$urlDestination = $urlForLinks.$urlVariation1.$stateDashes."-".$cityDashes;
					}								
				}							
			}
		}
		
		header("Location: $urlDestination");
	} else {
		unset($zip);
	}
}
//echo "<span style='color:white'>".$state." -- ".$city." -- ".$zip."</span>";

//init search type  
$searchType = 'none';

if(isset($city)) {
	$searchType = 'city';
	$cityNoDashes = str_replace('-', ' ', $city);
	if($state) {
		$statePieces = explode('-', $state);
		$statePieces = array_reverse($statePieces);
		$stateAbbrev = stateToAbb($state);
		// $sql = $wpdb->prepare("SELECT id, id as address1, city, state, zip, name, stateFull, lat, lng from nationallocations where city = %s AND state = %s AND type = 'normal'", $cityNoDashes, $stateAbbrev);
		$result=sql("SELECT DISTINCT id, State, ZipCode, Latitude, Longitude FROM zipcodes WHERE City='$cityNoDashes' AND State='$stateAbbrev' GROUP BY City ORDER BY City LIMIT 1;");
	} else {
		// $sql = $wpdb->prepare("SELECT id, id as address1, city, state, zip, name, stateFull, lat, lng from nationallocations where city = %s AND type = 'normal'", $cityNoDashes);
		$result=sql("SELECT DISTINCT id, State, ZipCode, Latitude, Longitude FROM zipcodes WHERE City='$cityNoDashes' GROUP BY City ORDER BY City LIMIT 1;");
	}
	// $locationsData = $wpdb->get_results( $sql, ARRAY_A );
	
	$data=mysql_fetch_row($result);
	
	//$locationsData[0]['address1'] = "190 Nonotuck St";
	$locationsData[0]['id'] = $data[0];
	$locationsData[0]['city'] = $cityNoDashes;
	$locationsData[0]['zip'] = $data[2];
	$locationsData[0]['state'] = $data[1];
	$locationsData[0]['stateFull'] = stateToFull($data[1]);
	$locationsData[0]['lat'] = $data[3];
	$locationsData[0]['lng'] = $data[4];
	
	//prepare for query by geo location
	$lat = $data[3]; // latitude of centre of bounding circle in degrees
	$lon = $data[4]; // longitude of centre of bounding circle in degrees
	$rad = 50; // radius of bounding circle in kilometers
	$R = 6371;  // earth's radius, km

	//first-cut bounding box (in degrees)
	$maxLat = $lat + rad2deg($rad/$R);
	$minLat = $lat - rad2deg($rad/$R);
	
	//compensate for degrees longitude getting smaller with increasing latitude
	$maxLon = $lon + rad2deg($rad/$R/cos(deg2rad($lat)));
	$minLon = $lon - rad2deg($rad/$R/cos(deg2rad($lat)));
	
	//pull regular clinics
	$result2=sql("SELECT dynamic_id, address1, city, state, zip, name, stateFull, lat, lng FROM localepage_dynamic WHERE city='$cityNoDashes' AND state='$data[1]' AND type='normal' ORDER BY address1;");
	if ((mysql_num_rows($result2)) == "0") {
		$result2=sql("SELECT dynamic_id, address1, city, state, zip, name, stateFull, lat, lng FROM localepage_dynamic WHERE lat>$minLat AND lat<$maxLat AND lng>$minLon AND lng<$maxLon AND type='normal' ORDER BY address1 LIMIT 10;");
	}

	//pull free clinics
	$result3=sql("SELECT dynamic_id, address1, city, state, zip, name, stateFull, lat, lng FROM localepage_dynamic WHERE city='$cityNoDashes' AND state='$data[1]' AND type='free' ORDER BY address1;");
	if ((mysql_num_rows($result3)) == "0") {
		$result3=sql("SELECT dynamic_id, address1, city, state, zip, name, stateFull, lat, lng FROM localepage_dynamic WHERE state='$data[1]' AND type='free' ORDER BY address1 LIMIT 5;");
	}

	//pull nearby cities
	$result4=sql("SELECT DISTINCT id, City, State FROM zipcodes WHERE Latitude>$minLat AND Latitude<$maxLat AND Longitude>$minLon AND Longitude<$maxLon AND City!='$cityNoDashes' AND state='$data[1]' GROUP BY City ORDER BY City LIMIT 51;");
	
	$wp_head_tags_stc[] = '<title>STD Testing in '.$cityNoDashes.' | STD Labs in '.$cityNoDashes.' | Getting an STD Test in '.$cityNoDashes.', '. $locationsData[0]['state'] .'</title>';
	$wp_head_tags_stc[] = '<meta name="description" content="All residents of '.$cityNoDashes.' have access to full STD Testing at these labs. Simply choose your preferred STD lab in '.$cityNoDashes.', '.$locationsData[0]['stateFull'].', order your customized STD Test selection and you can walk in to the clinic at any time during normal business hours." />';
	$wp_head_tags_stc[] = '<meta name="keywords" content="STD Test, STD Testing, HIV Test, HIV Testing, STD testing in '.$cityNoDashes.', '.$cityNoDashes.' STD Testing, Getting Tested '.$cityNoDashes.', '.$cityNoDashes.' HIV Test, AIDS test '.$cityNoDashes.', Chlamydia Test '.$cityNoDashes.', Herpes Testing in '.$cityNoDashes.' , Syphilis Test in '.$cityNoDashes.', Gonorrhea Test in '.$cityNoDashes.', Hepatitis Test in '.$cityNoDashes.', STD Testing '.$cityNoDashes.' '.$state.'" />';
} elseif(isset($state)) {
	$searchType = 'state';
	$statePieces = explode('-', $state);
	$statePieces = array_reverse($statePieces);
	$stateAbbrev = stateToAbb($state);
	// $sql = $wpdb->prepare( "SELECT distinct(city) as city, state, stateFull, zip from nationallocations where state=%s AND type = 'normal' order by city", $stateAbbrev);
	// $locationsData = $wpdb->get_results($sql, ARRAY_A);
	
	$locationsData[0]['state'] = $stateAbbrev;
	$locationsData[0]['stateFull'] = $state;
	
	$result=sql("SELECT DISTINCT id, City, State, State as stateFull, ZipCode as zip FROM zipcodes WHERE State='$stateAbbrev' GROUP BY City ORDER BY City;");
	$result2=sql("SELECT DISTINCT id, City, State, State as stateFull, ZipCode as zip FROM zipcodes WHERE State='$stateAbbrev' GROUP BY City ORDER BY City;");
	// $locationsData=mysql_fetch_array($result);
	// while($data=mysql_fetch_row($result)) {
		// echo("$data[0] - $data[1] - $data[2]<br />");
	// }
	//print_r($locationsData);
	
	$wp_head_tags_stc[] = '<title>'.$state.' STD Testing Centers | '.$state.' STD Clinics | Get Tested for STD\'s in '.$state.'</title>';
	$wp_head_tags_stc[] = '<meta name="description" content="Get tested for STD\'s in '.$state.': Simply choose your location online, order your customized STD Testing package, and you\'ll get instant access to testing. Test today, get results online in 2-3 business days." />';
	$wp_head_tags_stc[] = '<meta name="keywords" content="STD testing in '.$state.', STD Testing in '.$state.', '.$state.' STD Testing, '.$state.' STD Testing, Get Tested for STD\'s in '.$state.', '.$state.' HIV Testing , '.$state.' AIDS testing, '.$state.' Chlamydia Testing, '.$state.' Herpes Testing, '.$state.' Syphilis Tests, '.$state.' Gonorrhea Tests, '.$state.' Hepatitis Tests" />';
} else {
	$searchType = 'default';
	// $sql = "SELECT distinct(state) as state, stateFull from nationallocations WHERE type = 'normal' order by state";
	// $locationsData = $wpdb->get_results($wpdb->prepare($sql), ARRAY_A );
	// $locationsData[0]['state'] = "MA";
	// $locationsData[0]['stateFull'] = "Massachusetts";
	$wp_head_tags_stc[] = '<title>National STD Testing Clinic Database | US STD Labs</title>';
	$wp_head_tags_stc[] = '<meta name="description" content="Get tested for STD\'s anywhere in the U.S. Use this incredibly easy online ordering tool to choose your STD tests, then you will have the ability to walk in to a lab of your choice. Once your STD testing is complete, your test results will be available in our secure online ordering system." />';
    $wp_head_tags_stc[] = '<meta name="keywords" content="STDs, Testing, STD Labs in the US, National STD Labs, STD Testing in US, STD Clinic Database, STD Clinic, STD Tests, STD Testing, STD Clinics" />';
}

if (isset($city) && isset($state) && isset($zip)) $centersURL = "/centers-map.php?zip=$zip&city=$city&state=$state";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php 
		if ($wp_head_tags_stc[0] != "") echo $wp_head_tags_stc[0]."\n"; else echo "<title>STD Testing | Local STD Testing &amp; At Home STD Testing Kits</title>";
		if ($wp_head_tags_stc[1] != "") echo $wp_head_tags_stc[1]."\n"; else echo "<meta name=\"description\" content=\"STD testing is now confidential, quick and easy. Get STD tested at a local STD testing center or take an at home STD test. Select from 8 STD tests &amp; get tested at any local STD testing center. More on STD tests &amp;amp; at home STD testing kits on GetSTDtested\" />";
		if ($wp_head_tags_stc[2] != "") echo $wp_head_tags_stc[2]."\n"; else echo "<meta name=\"keywords\" content=\"std testing, std tests, local std testing, confidential std test, at home std testing kits std testing, std tests, local std testing, confidential std test, at home std testing kits\" />";
	?>
	<meta name="google-site-verification" content="VcxCN5pd-2HSnLTEz6m0sruDv7en2MiKwRLnEFxXt1w" />
	<link rel="icon" href="http://getstdtested.com/media/favicon/default/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="http://getstdtested.com/media/favicon/default/favicon.ico" type="image/x-icon" />
	<link rel="canonical" href="http://getstdtested.com<?php echo str_replace('stdtesting/%3Cbr%20/%3E%3Cb%3ENotice%3C/b%3E:%20%20Undefined%20index:%20SVR_NAME%20in%20%3Cb%3E/home/webapps/sites/magento/public/stdtesting/index%3C/b%3E%20on%20line%20%3Cb%3E232%3C/b%3E%3Cbr%20/%3E/', '', str_replace('stdtesting/%3Cbr%20/%3E%3Cb%3ENotice%3C/b%3E:%20%20Undefined%20index:%20SVR_NAME%20in%20%3Cb%3E/home/webapps/sites/magento/public/stdtesting/index%3C/b%3E%20on%20line%20%3Cb%3E232%3C/b%3E%3Cbr%20/%3E/stdtesting/%3Cbr%20/%3E%3Cb%3ENotice%3C/b%3E:%20%20Undefined%20index:%20SVR_NAME%20in%20%3Cb%3E/home/webapps/sites/magento/public/stdtesting/index%3C/b%3E%20on%20line%20%3Cb%3E232%3C/b%3E%3Cbr%20/%3E/stdtesting/%3Cbr%20/%3E%3Cb%3ENotice%3C/b%3E:%20%20Undefined%20index:%20SVR_NAME%20in%20%3Cb%3E/home/webapps/sites/magento/public/stdtesting/index%3C/b%3E%20on%20line%20%3Cb%3E232%3C/b%3E%3Cbr%20/%3E/stdtesting/%3Cbr%20/%3E%3Cb%3ENotice%3C/b%3E:%20%20Undefined%20index:%20SVR_NAME%20in%20%3Cb%3E/home/webapps/sites/magento/public/stdtesting/index%3C/b%3E%20on%20line%20%3Cb%3E232%3C/b%3E%3Cbr%20/%3E/', '', str_replace('stdtesting/%3Cbr%20/%3E%3Cb%3ENotice%3C/b%3E:%20%20Undefined%20index:%20SVR_NAME%20in%20%3Cb%3E/home/webapps/sites/magento/public/stdtesting/%3C/b%3E%20on%20line%20%3Cb%3E232%3C/b%3E%3Cbr%20/%3E/', '', str_replace('stdtesting/%3Cbr%20/%3E%3Cb%3ENotice%3C/b%3E:%20%20Undefined%20index:%20SVR_NAME%20in%20%3Cb%3E/home/webapps/sites/magento/public/stdtesting/index.php%3C/b%3E%20on%20line%20%3Cb%3E232%3C/b%3E%3Cbr%20/%3E/', '', str_replace('stdtesting/%3Cbr%20/%3E%3Cb%3ENotice%3C/b%3E:%20%20Undefined%20index:%20SVR_NAME%20in%20%3Cb%3E/home/webapps/sites/magento/public/stdtesting/index.php%3C/b%3E%20on%20line%20%3Cb%3E232%3C/b%3E%3Cbr%20/%3E/stdtesting/%3Cbr%20/%3E%3Cb%3ENotice%3C/b%3E:%20%20Undefined%20index:%20SVR_NAME%20in%20%3Cb%3E/home/webapps/sites/magento/public/stdtesting/index.php%3C/b%3E%20on%20line%20%3Cb%3E232%3C/b%3E%3Cbr%20/%3E/stdtesting/%3Cbr%20/%3E%3Cb%3ENotice%3C/b%3E:%20%20Undefined%20index:%20SVR_NAME%20in%20%3Cb%3E/home/webapps/sites/magento/public/stdtesting/index%3C/b%3E%20on%20line%20%3Cb%3E232%3C/b%3E%3Cbr%20/%3E/', '', str_replace('stdtesting/index.php', 'stdtesting/', $_SERVER["REQUEST_URI"])))))); ?>" />

	<script type="text/javascript" src="/js/detect-mobile.js"></script>
	<script type="text/javascript">
		try {
			var mobile = getQuerystring('Mobile');
			if (mobile == "") var mobile = getQuerystring('mobile', true);

			if ((mobile != "False") && (mobile != "false")) {
				detectMobile(navigator.userAgent || navigator.vendor || window.opera, 'http://getstdtested.com/m/04/');
			}
		} catch (err) { };
	</script>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript">
		function hideSticky() {
			if (jQuery(window).width() < 1235) jQuery("#b-get-tested-sticky").hide();
			else jQuery("#b-get-tested-sticky").show();
		}
		jQuery(document).ready(hideSticky);
		jQuery(window).resize(hideSticky);
	</script>

	<link rel="stylesheet" type="text/css" href="http://getstdtested.com/skin/frontend/enterprise/getstdtested/css/template.css" media="all" />

	<script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-10462432-1']);
	  _gaq.push(['_setDomainName', 'getstdtested.com']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	</script>

	<style media="screen" type="text/css">

		#logo { height: 100px; }

		#breadcrumbs { font-size: 10px; padding-bottom: 18px; }

		#center-map { width: 315px; height: 200px; border: solid 1px #5896AC; }
		#map-sideinfo { float:right; }
		p { text-align:left; }
		#maincontent h2 { font-size:17px; font-weight:normal; border:0px; line-height:19px; }

		a { color: #028AFB; text-decoration: none; }
		a:hover { color: #EA7640; text-decoration: none; }
		a.btn_orange:hover, a.btn_orange_25_reflection:hover, a.btn_orange_32_reflection:hover { color: #fff; }

		a.btn_orange_25_reflection { padding-top: 5px; font-size: 12px; }

		h1, h2, h3, h4, h5, h6 { clear: both; margin: 0; padding: 0; color: #111; font-family: Helvetica,Arial,"Lucida Grande",Verdana,sans-serif; }
		h1 { color: #023A4C; font-family: Tahoma,Geneva,sans-serif; font-size: 28px; line-height: 34px; }
		h2 { margin-bottom: 15px; font-size:17px; font-weight:normal; line-height:18px; }
		h3 { color: #0C6E8E; font-size:19px; font-weight:normal; }
		h4 { color: #F96D21; font-size:16px; font-weight:normal; }
		#footer h4 { font-weight: bold; }
		h5 { color: #313131; font-size:15px; font-weight:normal; padding-bottom: 3px; line-height: 21px; }
		h5 a { color:#0C6E8E; }

		#phone { color: #023A4C; }
		  
		#orderButton a {background: url(http://c0001470.cdn1.cloudfiles.rackspacecloud.com/get-your-test-today.png) no-repeat top left; display: block; width: 234px; height: 46px; text-indent: -9999px; font-size: 0; text-align:center}
		#orderButton a:hover {background-position: bottom left;}

		#findZip a {background: url(http://c189814.r14.cf1.rackcdn.com/btn-find-std-center-zip-code.png) no-repeat top left; display: block; width: 71px; height: 23px; text-indent: -9999px; font-size: 0; text-align:center}
		#findZip a:hover {background-position: bottom left;}

		#btnSeeTestsAndPrices a {font-size: 0em; line-height: 0em; background: url(http://c189814.r14.cf1.rackcdn.com/btn-see-std-tests-prices.png) no-repeat top left; display: block; width: 225px; height: 37px; text-indent: -9999px;}
		#btnSeeTestsAndPrices a:hover {background-position: bottom left;}

		#btnFindTestCenter a {font-size: 0em; line-height: 0em; background: url(http://c189814.r14.cf1.rackcdn.com/btn-find-std-testing-center.png) no-repeat top left; display: block; width: 225px; height: 37px; text-indent: -9999px;}
		#btnFindTestCenter a:hover {background-position: bottom left;}

		#img-state { margin: 3px 12px 15px 0; padding: 4px; border: 1px solid #bcbcbc; }

		#recommender.box_blue_header { width: 258px; margin-top: 0; margin-bottom: 20px; }
		#recommender .header h3 { font-size: 20px; font-weight: bold; }
		#recommender .content { padding-bottom: 32px; background-position: right 4px; }
		#recommender .test-recommender:hover { color: #fff; }

		.cboth { clear: both; }

	</style>

	<!-- Fancybox for Test Recommender -->
	<link rel="stylesheet" type="text/css" href="/test-recommender/jquery.fancybox-1.3.4.css" media="screen" />
	<script type="text/javascript" src="/test-recommender/jquery.fancybox-1.3.4.pack.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("a.test-recommender").fancybox({
				'width'				: 695,
				'height'			: 615,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe',
				'titleShow'			: false
			});
		});
		function closeFancyboxAndRedirectToUrl(url){
			jQuery.fancybox.close();
			window.location = url;
		}
	</script>
	<!-- EOF: Fancybox for Test Recommender -->

</head>


<body class=" core-index-index cms-home">


<a href="http://getstdtested.com/std-testing-options" id="b-get-tested-sticky">Get Tested</a>

<div id="header_wrapper" class="bg_white">

<div id="header" class="all">

    <a id="logo" href="http://getstdtested.com"></a>
        
    <div class="phone orange" id="header_phone">
    	<span id="header_phone_tagline">Questions? Call Now</span>
    	<div class="promoNumber" id="pnumber">
			866-749-6269
    	</div>
    </div>
    
	<script type="text/javascript">	
		p = '';		
		if (p.length > 6) {	
			document.getElementById('pnumber').innerHTML = '';
			document.getElementById('#question_side_widget .content p .orange').innerHTML = '';
			document.getElementById('#question_form_side_widget .content p.large .orange').innerHTML = '';		
		}	
	</script>
   
    <div id="user_nav">
	
    </div> <!-- /user_nav -->
    
    <div class="clear"></div>
    
    <div id="top_menu">
        <div class="content">
            <ul>
                <li><a href="http://getstdtested.com/std-tests" title="STD Tests">STD Tests</a>
                	<div class="top_submenu" id="submenu-tests">
						<ul>
							<li><strong>Popular Tests Package</strong></li>
							<li><a href="http://getstdtested.com/complete-std-test-package-information" title="Complete STD Test Package">Complete STD Test Package</a></li>
						</ul>
						<ul style="float: left;">
							<li><br /><strong>Individual Tests</strong></li>
							<li><a href="http://getstdtested.com/chlamydia-test" title="Chlamydia Test">Chlamydia Test</a></li>
							<li><a href="http://getstdtested.com/gonorrhea-test" title="Gonorrhea Test">Gonorrhea Test</a></li>
							<li><a href="http://getstdtested.com/hiv-test" title="HIV Test">HIV Test</a></li>
							<li><a href="http://getstdtested.com/hepatitis-b-test" title="Hepatitis B Test">Hepatitis B Test</a></li>
							<li><a href="http://getstdtested.com/hepatitis-c-test" title="Hepatitis C Test">Hepatitis C Test</a></li>
						</ul>
						<ul style="float: left;">
							<li><br /><strong>&nbsp;</strong></li>
							<li><a href="http://getstdtested.com/oral-herpes-test" title="Oral Herpes Test">Oral Herpes Test</a></li>
							<li><a href="http://getstdtested.com/genital-herpes-test" title="Genital Herpes Test">Genital Herpes Test</a></li>
							<li><a href="http://getstdtested.com/trichomoniasis-test" title="Trichomoniasis Test">Trichomoniasis Test</a></li>
							<li><a href="http://getstdtested.com/syphilis-test" title="Syphilis Test">Syphllis Test</a></li>
						</ul>
                    </div>
				</li>
                <li><a href="http://getstdtested.com/how-std-testing-works" title="How It Works">How It Works</a></li>
                <li><a href="http://getstdtested.com/at-home-std-tests" title="Home STD Testing">Home STD Testing</a></li>
                <li><a href="http://getstdtested.com/blog" title="Blog">Blog</a></li>
                <li class="last"><a href="http://getstdtested.com/sample-results" title="My Results">My Results</a></li>
            </ul>
        </div>
    </div> <!-- /top_menu -->
    
    <a id="order_now" class="btn_orange" href="http://getstdtested.com/std-testing-options">order now</a>

</div> <!-- /header -->

<div class="clear"></div>
<div class="sep20"></div>
 
    </div> <!-- /.bg_white -->

<div class="bg_white">
<div class="all">


<!-- *********************************** START MAIN CONTENT *********************************** -->                
 

	<div class="column span-10 first" id="maincontent" style="float: left; width: 680px;"><!-- START DIV CONTENT2 -->  
    
		<div class="content2"><!-- START DIV CONTENT2 -->  
                                  
			<div>     
				<?php if($searchType=='city') {
					$stateDashes = strtolower(str_replace(' ', '-', $locationsData[0]['stateFull']));
					$linkState = strtolower($stateDashes."-".$locationsData[0]['state']);
					$_SESSION['addressInput'] = $locationsData[0]['zip'];
					echo "<div id=\"breadcrumbs\"><a href=\"".$urlForLinks."\" title=\"STD Testing\">STD Testing</a> &raquo; ";
						if (stateID($locationsData[0]['state']) % 4 == 0) { 
							echo "<a href=\"".$urlForLinks.$stateDashes.$urlVariation4."\"";
						} else {
							if (stateID($locationsData[0]['state']) % 3 == 0) { 
								echo "<a href=\"".$urlForLinks.$urlVariation3.$stateDashes."\"";
							} else {
								if (stateID($locationsData[0]['state']) % 2 == 0) { 
									echo "<a href=\"".$urlForLinks.$stateDashes.$urlVariation2."\"";
								} else {
									if (stateID($locationsData[0]['state']) % 1 == 0) { 
										echo "<a href=\"".$urlForLinks.$urlVariation1.$stateDashes."\"";
									}
								}							
							}
						}
						echo " title=\"".$locationsData[0]['stateFull']." STD Testing\">".$locationsData[0]['stateFull']." STD Testing</a> &raquo; ".$locationsData[0]['city']." STD Testing</div>
					<h1>STD Testing in ".$locationsData[0]['city']."</h1>";
					?>
					
					<div style="padding-bottom:20px;">
						<div style="float:right; width:345px; height:410px; background-color:#d8eef5; border-radius: 5px; border:solid 1px #5896ac; margin-left:20px; margin-bottom:15px;">
							<div style="padding:15px; text-align:center;">
								<h2>Locate a STD Testing Center in <?php echo $locationsData[0]['city']; ?> and get tested today.</h2>
                                <div style="text-align:left;">
									<?php echo "<a href=\"".genStateURL($locationsData[0]['stateFull'])."\" title=\"".$locationsData[0]['stateFull']." STD Testing\">See All ".$locationsData[0]['stateFull']." STD Centers</a>";
										if($searchType=='city'){?>    
                                        <div id="center-map"></div>
                                    <?php } ?>
									<div style="text-align: center;">
                                		<a href="http://getstdtested.com/std-testing-options" class="btn_orange_32_reflection" style="margin: 22px 0 12px 0;">See Tests &amp; Prices</a>
										Have questions? We're here to talk:<br /><span id="phone" style="font-size:22px;">855-287-6195</span>
                                	</div>
                                </div>
							</div>
						</div>
					
						<?php echo genCityContent($locationsData[0]['id'], $locationsData[0]['city'], 'intro'); ?>
						<div class="cboth"></div>
					</div>

						<div style="width:237px; float:left; margin-right:20px;" class="post-2119 post type-post status-publish format-standard sticky hentry category-std-testing tag-std-research tag-std-treatment tag-who" id="post-2119">
							<div class="entry">
								<img src="<?php echo $urlForLinks; ?>images/benefits-of-std-testing.jpg" width="237" height="120" alt="" border="0" style="margin-bottom: 10px;" /><br />
								<?php echo genCityContent($locationsData[0]['id'], $locationsData[0]['city'], 'benefits'); ?>
							</div>
						</div>

						<div style="width: 185px; float:left; padding-top: 50px;">
							<img src="<?php echo $urlForLinks; ?>images/trustbuilders2.jpg" width="165" height="240" alt="Trusted & Accredited" border="0" />
						</div>
						
						<div style="width:237px; float:left;" class="post-2014 post type-post status-publish format-standard sticky hentry category-std-testing tag-herpes-confirmation-testing tag-herpes-testing-2" id="post-2014">
							<div class="entry">
								<img src="<?php echo $urlForLinks; ?>images/private-std-testing.jpg" width="237" height="120" alt="" border="0" style="margin-bottom: 10px;" /><br />
								<?php echo genCityContent($locationsData[0]['id'], $locationsData[0]['city'], 'privacy'); ?>
							</div>
						</div>
						<div class="cboth"></div>
					
        			<?php
					echo "<p><br /><h3>STD Testing Centers near ".$locationsData[0]['city']."</h3></p>";
					
					$i=0;
					while($data=mysql_fetch_row($result4)) {
						$stateDashes = strtolower(str_replace(' ', '-', $state));
						$cityDashes = str_replace(' ', '-', strtolower($data[1]));
						echo "<div style=\"float:left;\">";
						echo "<p style=\"width:205px; margin: 0 20px 0 0; padding: 7px 0; font-size: 12px;\">";
						if ($data[0] % 4 == 0) { 
							echo "<a href=\"".$urlForLinks.$stateDashes."-".$cityDashes.$urlVariation4."\"";
						} else {
							if ($data[0] % 3 == 0) { 
								echo "<a href=\"".$urlForLinks.$urlVariation3.$stateDashes."-".$cityDashes."\"";
							} else {
								if ($data[0] % 2 == 0) { 
									echo "<a href=\"".$urlForLinks.$stateDashes."-".$cityDashes.$urlVariation2."\"";
								} else {
									if ($data[0] % 1 == 0) { 
										echo "<a href=\"".$urlForLinks.$urlVariation1.$stateDashes."-".$cityDashes."\"";
									}								
								}							
							}
						}
						echo " title=\"STD Testing in ".ucwords(strtolower($data[1]))." , ".$statePieces[0]." \" >" . ucwords(strtolower($data[1])) . ", $statePieces[0] STD Testing</a></p>";
						echo "</div>";
						$i++;
						if ($i % 3 == 0) echo "<div class=\"cboth\"></div>";
					}



				} elseif($searchType=='state') {
				
				?>
						<div id="breadcrumbs"><a href="<?php echo $urlForLinks; ?>" title="STD Testing">STD Testing</a> &raquo; <?php echo $locationsData[0]['stateFull']; ?> STD Testing</div>
						
						<h1><?php echo $locationsData[0]['stateFull']; ?> STD Testing Locations</h1>

						<div style="padding-bottom: 15px;">
						
							<div style="float:right; width:345px; background-color:#d8eef5; border-radius: 5px; border:solid 1px #5896ac; margin-left:20px; padding-bottom:15px;">
								<div style="padding:15px; text-align:center;">
									<h2>Locate a STD Testing Center in <?php echo $locationsData[0]['stateFull']; ?> and get tested today.</h2>
									<form style="text-align:right; margin-right:52px;" id="zipcodeFormState" name="zipcodeFormState" method="post" action="">
										<label for="city">City</label>
										<select style="width:184px;" name="city" id="city">
											<option value="">Please Select</option>
										<?php
											while($data=mysql_fetch_row($result)) {
												$stateDashes = strtolower(str_replace(' ', '-', $state));
												$cityDashes = str_replace(' ', '-', strtolower($data[1]));
												if ($data[0] % 4 == 0) { 
													echo "<option value=\"".$urlForLinks.$stateDashes."-".$cityDashes.$urlVariation4."\">";
												} else {
													if ($data[0] % 3 == 0) { 
														echo "<option value=\"".$urlForLinks.$urlVariation3.$stateDashes."-".$cityDashes."\">";
													} else {
														if ($data[0] % 2 == 0) { 
															echo "<option value=\"".$urlForLinks.$stateDashes."-".$cityDashes.$urlVariation2."\">";
														} else {
															if ($data[0] % 1 == 0) { 
																echo "<option value=\"".$urlForLinks.$urlVariation1.$stateDashes."-".$cityDashes."\">";
															}								
														}							
													}
												}
												echo ucwords(strtolower($data[1])) . "</option>";
											}
										?>
										</select>
									</form>
									<a href="javascript:void(0);" onclick="document.zipcodeFormState.action=document.getElementById('city').value;document.zipcodeFormState.submit();" class="btn_orange_32_reflection" style="margin: 18px 0 16px 0;">Find STD Testing Center</a>
									Have questions? We're here to talk:<br /><span id="phone" style="font-size:22px;">855-287-6195</span><br />
									<p>getSTDtested.com offers a variety of STD tests to choose from. Get tested for any one of the following or a combination of tests including:</p>
									<div style="text-align:left; width:130px; float:left; margin-left:15px;">
										<ul>
											<li><h5><a href="http://getstdtested.com/chlamydia-test">Chlamydia</a></h5></li>
											<li><h5><a href="http://getstdtested.com/hepatitis-b-test">Hepatitis B</a></h5></li>
											<li><h5><a href="http://getstdtested.com/syphilis-test">Syphilis</a></h5></li>
											<li><h5><a href="http://getstdtested.com/oral-herpes-test">Oral Herpes</a></h5></li>
											<li><h5><a href="http://getstdtested.com/trichomoniasis-test">Trichomoniasis</a></h5></li>
										</ul>
									</div>
									<div style="text-align:left; width:140px; float:left;">
										<ul>
											<li><h5><a href="http://getstdtested.com/gonorrhea-test">Gonorrhea</a></h5></li>
											<li><h5><a href="http://getstdtested.com/hepatitis-c-test">Hepatitis C</a></h5></li>
											<li><h5><a href="http://getstdtested.com/hiv-test">HIV</a></h5></li>
											<li><h5><a href="http://getstdtested.com/genital-herpes-test">Genital Herpes</a></h5></li>
										</ul>
									</div>
								</div>
							</div>
							
							<?php echo genStateContent(stateID($locationsData[0]['stateFull']), $locationsData[0]['stateFull'], 'intro'); ?>
						
							<div class="cboth"></div>
						</div>
						
						<img src="<?php echo $urlForLinks; ?>images/trustbuilders.jpg" width="678" height="125" alt="Trusted & Accredited" border="0" />
						
						<div class="cboth"></div>
        			<?php
					echo "<br /><h3>STD Testing Centers in ".$locationsData[0]['stateFull']."</h3><br />";
					
					$i=0;					
					while($data=mysql_fetch_row($result2)) {
						$stateDashes = strtolower(str_replace(' ', '-', $state));
						$cityDashes = str_replace(' ', '-', strtolower($data[1]));
						echo "<div style=\"float:left;\">";
						echo "<p style=\"width:205px; margin: 0 20px 0 0; padding: 7px 0; font-size: 12px;\">";
						if ($data[0] % 4 == 0) { 
							echo "<a href=\"".$urlForLinks.$stateDashes."-".$cityDashes.$urlVariation4."\"";
						} else {
							if ($data[0] % 3 == 0) { 
								echo "<a href=\"".$urlForLinks.$urlVariation3.$stateDashes."-".$cityDashes."\"";
							} else {
								if ($data[0] % 2 == 0) { 
									echo "<a href=\"".$urlForLinks.$stateDashes."-".$cityDashes.$urlVariation2."\"";
								} else {
									if ($data[0] % 1 == 0) { 
										echo "<a href=\"".$urlForLinks.$urlVariation1.$stateDashes."-".$cityDashes."\"";
									}								
								}							
							}
						}
						echo " title=\"STD Testing in ".ucwords(strtolower($data[1]))." , ".$statePieces[0]." \" >" . ucwords(strtolower($data[1])) . ", $statePieces[0] STD Testing</a></p>";
						echo "</div>";
						$i++;
						if ($i % 3 == 0) echo "<div class=\"cboth\"></div>";
					}

				} else {
				?>
					<div style="height:210px; background-color:#d8eef5; border-radius: 5px; border:solid 1px #5896ac; margin-top: 3px; margin-bottom:20px;">
						<div style="padding:20px;">
							<div style="float:left; width:345px;">
							<h1 style="font-size: 21px;">Find STD Testing Near You</h1>
								Local STD testing has never been easier to find. With over 4,000 STD testing locations across the country, there's likely a facility in your neck of the woods. Simply search our database to find a private, FDA-approved STD test center in your area, and then test for the most common STDs. Test as early as today&ndash;no appointment necessary; just walk in any time during operating hours and get results within 3 to 5 days after testing.
							</div>
							<div style="float:right; width:280px; text-align:center;"><h2>Locate a STD Testing Center in your city and get tested today.</h2>
								<form style="text-align:right; margin-right:50px;" id="zipcodeFormState2" name="zipcodeFormState2" method="post" action="">
									<label for="state-locations-picker">State</label>
									<select style="width:150px;" name="state" id="state">
										<option value="">Please Select</option>
										<option value="<?php echo genStateURL('Alaska'); ?>">Alaska</option>
										<option value="<?php echo genStateURL('Alabama'); ?>">Alabama</option>
										<option value="<?php echo genStateURL('Arkansas'); ?>">Arkansas</option>
										<option value="<?php echo genStateURL('Arizona'); ?>">Arizona</option>
										<option value="<?php echo genStateURL('California'); ?>">California</option>
										<option value="<?php echo genStateURL('Colorado'); ?>">Colorado</option>
										<option value="<?php echo genStateURL('Connecticut'); ?>">Connecticut</option>
										<option value="<?php echo genStateURL('District-Of-Columbia'); ?>">District of Columbia</option>
										<option value="<?php echo genStateURL('Delaware'); ?>">Delaware</option>
										<option value="<?php echo genStateURL('Florida'); ?>">Florida</option>
										<option value="<?php echo genStateURL('Georgia'); ?>">Georgia</option>
										<option value="<?php echo genStateURL('Iowa'); ?>">Iowa</option>
										<option value="<?php echo genStateURL('Idaho'); ?>">Idaho</option>
										<option value="<?php echo genStateURL('Illinois'); ?>">Illinois</option>
										<option value="<?php echo genStateURL('Indiana'); ?>">Indiana</option>
										<option value="<?php echo genStateURL('Kansas'); ?>">Kansas</option>
										<option value="<?php echo genStateURL('Kentucky'); ?>">Kentucky</option>
										<option value="<?php echo genStateURL('Louisiana'); ?>">Louisiana</option>
										<option value="<?php echo genStateURL('Massachusetts'); ?>">Massachusetts</option>
										<option value="<?php echo genStateURL('Maryland'); ?>">Maryland</option>
										<option value="<?php echo genStateURL('Maine'); ?>">Maine</option>
										<option value="<?php echo genStateURL('Michigan'); ?>">Michigan</option>
										<option value="<?php echo genStateURL('Minnesota'); ?>">Minnesota</option>
										<option value="<?php echo genStateURL('Missouri'); ?>">Missouri</option>
										<option value="<?php echo genStateURL('Mississippi'); ?>">Mississippi</option>
										<option value="<?php echo genStateURL('Montana'); ?>">Montana</option>
										<option value="<?php echo genStateURL('North-Carolina'); ?>">North Carolina</option>
										<option value="<?php echo genStateURL('Nebraska'); ?>">Nebraska</option>
										<option value="<?php echo genStateURL('New-Hampshire'); ?>">New Hampshire</option>
										<option value="<?php echo genStateURL('New-Jersey'); ?>">New Jersey</option>
										<option value="<?php echo genStateURL('New-Mexico'); ?>">New Mexico</option>
										<option value="<?php echo genStateURL('Nevada'); ?>">Nevada</option>
										<option value="<?php echo genStateURL('New-York'); ?>">New York</option>
										<option value="<?php echo genStateURL('Ohio'); ?>">Ohio</option>
										<option value="<?php echo genStateURL('Oklahoma'); ?>">Oklahoma</option>
										<option value="<?php echo genStateURL('Oregon'); ?>">Oregon</option>
										<option value="<?php echo genStateURL('Pennsylvania'); ?>">Pennsylvania</option>
										<option value="<?php echo genStateURL('Rhode-Island'); ?>">Rhode Island</option>
										<option value="<?php echo genStateURL('South-Carolina'); ?>">South Carolina</option>
										<option value="<?php echo genStateURL('South-Dakota'); ?>">South Dakota</option>
										<option value="<?php echo genStateURL('Tennessee'); ?>">Tennessee</option>
										<option value="<?php echo genStateURL('Texas'); ?>">Texas</option>
										<option value="<?php echo genStateURL('Utah'); ?>">Utah</option>
										<option value="<?php echo genStateURL('Virginia'); ?>">Virginia</option>
										<option value="<?php echo genStateURL('Vermont'); ?>">Vermont</option>
										<option value="<?php echo genStateURL('Washington'); ?>">Washington</option>
										<option value="<?php echo genStateURL('Wisconsin'); ?>">Wisconsin</option>
										<option value="<?php echo genStateURL('West-Virginia'); ?>">West Virginia</option>
										<option value="<?php echo genStateURL('Wyoming'); ?>">Wyoming</option>
									</select>
									<br />
								</form>
								<a href="javascript:void()" onclick="document.zipcodeFormState2.action=document.getElementById('state').value;document.zipcodeFormState2.submit();" class="btn_orange_32_reflection" style="margin: 18px 0 16px 0;">Find STD Testing Center</a>
								Have questions? We're here to talk:<br /><strong id="phone">855-287-6195</strong>
							</div>
						</div>
					</div>

					<img src="<?php echo $urlForLinks; ?>images/trustbuilders.jpg" width="678" height="125" alt="Trusted & Accredited" border="0" />

					<h3><br />STD Testing Options by State</h3>
					<p>Each state has dozens&ndash;even hundreds&ndash;of local STD testing options. All STD testing facilities are completely private; all labs offer a full range of diagnostic services, so no one will know why you are at the lab. Personal information, including STD test results, is never shared. Labs are all FDA-approved and offer the same high-quality STD tests used by doctors and hospitals nationwide.</p>
					<div style="float:left;">
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Alaska'); ?>" title="STD Testing Centers in AK" >Alaska STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Alabama'); ?>" title="STD Testing Centers in AL" >Alabama STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Arkansas'); ?>" title="STD Testing Centers in AR" >Arkansas STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Arizona'); ?>" title="STD Testing Centers in AZ" >Arizona STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('California'); ?>" title="STD Testing Centers in CA" >California STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Colorado'); ?>" title="STD Testing Centers in CO" >Colorado STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Connecticut'); ?>" title="STD Testing Centers in CT" >Connecticut STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('District Of Columbia'); ?>" title="STD Testing Centers in DC" >District of Columbia STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Delaware'); ?>" title="STD Testing Centers in DE" >Delaware STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Florida'); ?>" title="STD Testing Centers in FL" >Florida STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Georgia'); ?>" title="STD Testing Centers in GA" >Georgia STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Iowa'); ?>" title="STD Testing Centers in IA" >Iowa STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Idaho'); ?>" title="STD Testing Centers in ID" >Idaho STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Illinois'); ?>" title="STD Testing Centers in IL" >Illinois STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Indiana'); ?>" title="STD Testing Centers in IN" >Indiana STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Kansas'); ?>" title="STD Testing Centers in KS" >Kansas STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Kentucky'); ?>" title="STD Testing Centers in KY" >Kentucky STD Testing</a></p>
					</div>
					<div style="float:left;">
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Louisiana'); ?>" title="STD Testing Centers in LA" >Louisiana STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Massachusetts'); ?>" title="STD Testing Centers in MA" >Massachusetts STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Maryland'); ?>" title="STD Testing Centers in MD" >Maryland STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Maine'); ?>" title="STD Testing Centers in ME" >Maine STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Michigan'); ?>" title="STD Testing Centers in MI" >Michigan STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Minnesota'); ?>" title="STD Testing Centers in MN" >Minnesota STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Missouri'); ?>" title="STD Testing Centers in MO" >Missouri STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Mississippi'); ?>" title="STD Testing Centers in MS" >Mississippi STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Montana'); ?>" title="STD Testing Centers in MT" >Montana STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('North Carolina'); ?>" title="STD Testing Centers in NC" >North Carolina STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Nebraska'); ?>" title="STD Testing Centers in NE" >Nebraska STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('New Hampshire'); ?>" title="STD Testing Centers in NH" >New Hampshire STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('New Jersey'); ?>" title="STD Testing Centers in NJ" >New Jersey STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('New Mexico'); ?>" title="STD Testing Centers in NM" >New Mexico STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Nevada'); ?>" title="STD Testing Centers in NV" >Nevada STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('New York'); ?>" title="STD Testing Centers in NY" >New York STD Testing</a></p>
					</div>
					<div style="float:left;">
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Ohio'); ?>" title="STD Testing Centers in OH" >Ohio STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Oklahoma'); ?>" title="STD Testing Centers in OK" >Oklahoma STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Oregon'); ?>" title="STD Testing Centers in OR" >Oregon STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Pennsylvania'); ?>" title="STD Testing Centers in PA" >Pennsylvania STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Rhode Island'); ?>" title="STD Testing Centers in RI" >Rhode Island STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('South Carolina'); ?>" title="STD Testing Centers in SC" >South Carolina STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('South Dakota'); ?>" title="STD Testing Centers in SD" >South Dakota STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Tennessee'); ?>" title="STD Testing Centers in TN" >Tennessee STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Texas'); ?>" title="STD Testing Centers in TX" >Texas STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Utah'); ?>" title="STD Testing Centers in UT" >Utah STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Virginia'); ?>" title="STD Testing Centers in VA" >Virginia STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Vermont'); ?>" title="STD Testing Centers in VT" >Vermont STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Washington'); ?>" title="STD Testing Centers in WA" >Washington STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Wisconsin'); ?>" title="STD Testing Centers in WI" >Wisconsin STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('West Virginia'); ?>" title="STD Testing Centers in WV" >West Virginia STD Testing</a></p>
						<p style="width:205px; margin-right:20px;"><a href="<?php echo genStateURL('Wyoming'); ?>" title="STD Testing Centers in WY" >Wyoming STD Testing</a></p>
					</div>
        		<?php
				}
				?>

				<br />
            
            </div>    
                        
		</div><!-- END DIV CONTENT2 -->  
        
	</div><!-- END DIV MAINCONTENT -->  
    
    
<!-- *********************************** END MAIN CONTENT *********************************** -->                
                
                
<!-- *********************************** START SIDEBAR CITY/LOCATION *********************************** -->                
                
        
        <?php if ($searchType=='city') { ?>
        
        <div class="column span-4 last" style="float: right; width: 260px;">
            <div style="background-color:#F9FBD6; border-radius: 5px; border:solid 1px #E1E5A3; margin-top: 3px; margin-bottom:20px;">
                <div style="padding:15px;">
                    <h5>STD Testing Centers</h5>
                    *More Details Available During Ordering<br /><br />
                    <?php
						$gmapMarkers = "";
						while($data=mysql_fetch_row($result2)) {

							$addressDashes = str_replace(' ', '-', $data[0])."-".$data[4];
							$cityDashes = strtolower(str_replace(' ', '-', strtolower($data[2])));
							$stateDashes = strtolower(str_replace(' ', '-', $locationsData[0]['stateFull'])."-".$locationsData[0]['state']);

							echo "
								<div class=\"clinic-info\" id=\"x". $addressDashes ."\">
									<a href=\"http://getstdtested.com/std-test-centers/".$stateDashes."/".$cityDashes."/".$addressDashes."\" title=\"". $data[5] ."\">". $data[5] ."</a>
									<div class=\"address\">
										".$data[2].", ".$data[3]." ".$data[4]."<br />
										866-749-6269
									</div>
									<div class=\"extra-links\">
										<b>";
							if (isset($_SESSION['affPhone'])) echo $_SESSION['affPhone'];
							echo "</b>
										<a href=\"javascript:void(0);\" onclick=\"document.sidebarOrderFrm.zipcode.value='". $data[4] ."';document.sidebarOrderFrm.submit();\" title=\"Click to order at this location\"><div style=\"margin-bottom:15px; font-weight:bold;\">Order Online</div></a>
									</div>
								</div>
							";
							
							$gmapMarkers .= "[". $data[0] .", '". $data[5] ."', ". $data[7] .", ". $data[8] ."],\n";
							
						}
                    ?>
                </div>
            </div>
			<div style="padding: 0 0 15px 15px;">
				<h5>Potential Free STD Testing Centers</h5>
				<?php
					while($data=mysql_fetch_row($result3)) {

						$addressDashes = str_replace(' ', '-', $data[0])."-".$data[4];
						$cityDashes = strtolower(str_replace(' ', '-', strtolower($data[2])));
						$stateDashes = strtolower(str_replace(' ', '-', $locationsData[0]['stateFull'])."-".$locationsData[0]['state']);

						echo "
							<div class=\"clinic-info\" id=\"x". $addressDashes ."\">
								<a href=\"http://getstdtested.com/free-std-clinics/".$stateDashes."/".$cityDashes."/".$addressDashes."\" title=\"". $data[5] ."\">". $data[5] ."</a>
								<div class=\"address\">
									".$data[1]."<br />
									".$data[2].", ".$data[3]." ".$data[4]."
								</div>
								<div class=\"extra-links\">
									<a href=\"javascript:void(0);\" onclick=\"document.sidebarOrderFrm.zipcode.value='". $data[4] ."';document.sidebarOrderFrm.submit();\" title=\"Click to order at this location\"><div style=\"margin-bottom:15px; font-weight:bold;\">Order Online</div></a>
								</div>
							</div>
						";
						
					}
				?>
			</div>
			<div id="recommender" class="box_blue_header">
				<div class="header">
					<h3 class="acenter">test recommender</h3>
					<p class="acenter">Not sure what to get tested for?</p>
				</div>
				<div class="content">
					<p style="line-height: 20px;">Get answers with our nationally-backed STD test recommender.</p>
					<a class="test-recommender btn_blue_reflection" href="/test-recommender/test-recommendation.php">start</a>
				</div>
			</div>
			
			<?php
				//$url = 'http://api.twitter.com/1/getSTDtested/lists/sex-and-sexual-health/statuses.atom';
				$url = str_replace(" ", "+", "http://search.twitter.com/search.rss?q=std OR stds OR 'sexually OR transmitted OR diseases' OR herpes OR hiv OR syphilis OR gonorrhea OR chlamydia -fuck -pussy -shit -ass -dick -asshole -slut -bitch lang:en geocode:". $locationsData[0]['lat'] .",". $locationsData[0]['lng'] .",150km&rpp=5");
				include_once 'rss/rss-twitter.php';
			?>
			
        </div>  
                          
		<?php } ?>
                    
                    
<!-- *********************************** END SIDEBAR CITY/LOCATION *********************************** -->                
                    

<!-- *********************************** START SIDEBAR NATIONAL/STATE *********************************** -->                

                 
		<?php if ($searchType=='state' || $searchType=='default') { ?>

		<div class="column span-4 last" style="float: right; width: 260px;">
			<div style="height:95px; background-color:#F9FBD6; border-radius: 5px; border:solid 1px #E1E5A3; margin-top: 3px; margin-bottom:20px;">
				<div style="padding:15px;">
					<h2 style="font-size: 16px;">STD Testing Centers Near You</h2>
					<div style="margin-top: 0; float:left;">
                    	<form id="zipcodeForm" name="zipcodeForm" method="post" action="#">
							<input style="height:20px;" name="zipcode" type="zipcode" id="zipcode" value="Enter Your Zip Code" size="20" onfocus="this.value=''"/>
						</form>
                    </div>
					<a href="javascript:void(0);" onclick="validateZipcode();" class="btn_orange_25_reflection" style="margin: 10px 0 10px 160px;">FIND</a>
				</div>
			</div>
			<div id="quote_wrap" class="cboth" style="height: 178px;">
				<div class="textItem" style="width:260px;">
					<div style="float:left; margin-right:10px; margin-bottom:10px;">
						<img src="http://getstdtested.com/stdtesting/images/medical-board-photo-1.jpg" width="105" height="70" alt="Doctor Handsfield STD Testing Medical Board Expert" style="margin-top: 3px;" />
					</div>
					With over 30+ years of experience and 250 publications under his belt, Dr. Handsfield has played an integral role in developing modern day STD prevention strategies.
					<p style="margin-top: 10px;"><b>H. Hunter Handsfield, M.D.</b><br />
					<span style="font-size: 11px; font-style: italic;">getSTDtested.com Medical Advisory Board</span></p>
				</div>
				<div class="textItem" style="width:260px;">
					<div style="float:left; margin-right:10px; margin-bottom:10px;">
						<img src="http://getstdtested.com/stdtesting/images/medical-board-photo-2.jpg" width="105" height="70" alt="Doctor Van Der Pol STD Testing Medical Board Expert" style="margin-top: 3px;" />
					</div>
					Dr. Van Der Pol is a leading advisor for the Centers for Disease Control (CDC) and the National Chlamydia Coalition, performing cutting-edge STD research.
					<p style="margin-top: 10px;"><b>Barbara Van Der Pol, PhD, MPH</b><br />
					<span style="font-size: 11px; font-style: italic;">getSTDtested.com Medical Advisory Board</span></p>
				</div>
				<div class="textItem" style="width:260px;">
					<div style="float:left; margin-right:10px; margin-bottom:10px;">
						<img src="http://getstdtested.com/stdtesting/images/medical-board-photo-3.jpg" width="105" height="70" alt="Doctor Skolnik STD Testing Medical Board Expert" style="margin-top: 3px;" />
					</div>
					Dr. Skolnik is a well-known presenter and recent recipient of the "Top Doctor" Award in Family Medicine by Philadelphia Magazine, regularly contributing to CDC editorial.
					<p style="margin-top: 10px;"><b>Neil S. Skolnik, MD</b><br />
					<span style="font-size: 11px; font-style: italic;">getSTDtested.com Medical Advisory Board</span></p>
				</div>
			</div>
			<div id="recommender" class="box_blue_header">
				<div class="header">
					<h3 class="acenter">test recommender</h3>
					<p class="acenter">Not sure what to get tested for?</p>
				</div>
				<div class="content">
					<p style="line-height: 20px;">Get answers with our nationally-backed STD test recommender.</p>
					<a class="test-recommender btn_blue_reflection" href="/test-recommender/test-recommendation.php">start</a>
				</div>
			</div>
            <div style="width:260px; font-size: 12px;">
                <h4>Test Today</h4>
                No wait. Order and test for STDs today.<br /><br />

                <h4>Fast Results</h4>
                STD test results available within 1-5 business days through confidential online patient portal.<br /><br />
                
                <h4>Treatment Options</h4>
                STDs are better managed with early detection; some STDs are even curable with a simple prescription prescribed by our in-house physician network.<br /><br />
                
                <h4>Free Physician Consult</h4>
                Ask questions and get help interpreting personal STD test results through a complimentary consultation with our in-house physician network.<br /><br />
                
                <h4>Highest Accuracy Available</h4>
                We partner with the same trusted labs used by doctors and hospitals nationwide, offering the highest accuracy STD testing available on the market; 99.9% STD test accuracy.<br /><br />
                
                <h4>Convenient</h4>
                With partnerships at over 4,000+ nationwide labs, select a private lab close to your work or home in (INSERT STATE)<br /><br />
                
                <h4>No insurance records</h4>
                Test results are completely private.
            </div>
			
			<br /><br /><br />
			
			<?php 
				if (isset($state)) {
					//$url = 'http://news.google.com/news?hl=en&ds=n&pq=std&cp=44&gs_id=su&xhr=t&q='.str_replace(" ", "+", $state).'+std+hiv+herpes+syphilis+chlamydia+gonorrhea+hepatitis&gl=us&bav=on.2,or.r_gc.r_pw.r_qf.&biw=1680&bih=876&um=1&ie=UTF-8&output=rss';
					$url = 'http://news.search.yahoo.com/rss?ei=UTF-8&va_vt=any&vo=std+hiv+herpes+syphilis+chlamydia+gonorrhea+hepatitis&vo_vt=any&ve_vt=any&vp_vt=any&fl=1&vl=lang_en&smonth=11&emonth=12&sday=8&eday=8&location='.str_replace(" ", "+", $state).'&catfilt=1';
					$urlRead = 'http://news.google.com/news?hl=en&ds=n&pq=std&cp=44&gs_id=su&xhr=t&q='.str_replace(" ", "+", $state).'+std+hiv+herpes+syphilis+chlamydia+gonorrhea+hepatitis&gl=us&bav=on.2,or.r_gc.r_pw.r_qf.&biw=1680&bih=876&um=1&ie=UTF-8';
				} else{ 
					//$url = 'http://news.google.com/news?hl=en&ds=n&pq=std&cp=44&gs_id=su&xhr=t&q=std+hiv+herpes+syphilis+chlamydia+gonorrhea+hepatitis&gl=us&bav=on.2,or.r_gc.r_pw.r_qf.&biw=1680&bih=876&um=1&ie=UTF-8&output=rss';
					$url = 'http://news.search.yahoo.com/rss?ei=UTF-8&va_vt=any&vo=std+hiv+herpes+syphilis+chlamydia+gonorrhea+hepatitis&vo_vt=any&ve_vt=any&vp_vt=any&fl=1&vl=lang_en&smonth=11&emonth=12&sday=8&eday=8&location=&catfilt=1';
					$urlRead = 'http://news.google.com/news?hl=en&ds=n&pq=std&cp=44&gs_id=su&xhr=t&q=std+hiv+herpes+syphilis+chlamydia+gonorrhea+hepatitis&gl=us&bav=on.2,or.r_gc.r_pw.r_qf.&biw=1680&bih=876&um=1&ie=UTF-8';
				}
				include_once 'rss/rss-news.php';
			?>
			
		</div>

		<?php } ?>
                    
                    
<!-- *********************************** END SIDEBAR NATIONAL/STATE *********************************** -->                

    
</div><!-- END DIV PAGE -->

<div class="cboth"><br /><br /></div>
    
    
<form name="sidebarOrderFrm" method="POST" action="http://getstdtested.com/std-testing-options">
<input type="hidden" name="zipcode">
</form>

<form name="dropLocFinder" method="POST" action="http://getstdtested.com/locate-testing-center">
<input type="hidden" name="zipcode">
</form>    
    

<input type="hidden" size="10" id="addressInput" name="addressInput" value="<?php echo $_SESSION['addressInput']; ?>" />

<!-- Google Maps and some Javascript magic... -->
<?php if ($searchType=='city') { ?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script language="javascript">
var map;
var zipvalue;
var geocoder;

function initialize() {
	var myLatlng = new google.maps.LatLng(40, -100);
	var zipvalue = $('#addressInput').val();
	geocoder = new google.maps.Geocoder();
	var myOptions = {
		zoom: 3,
		disableDefaultUI: true,
		navigationControl: true,
		center: myLatlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	map = new google.maps.Map(document.getElementById("center-map"), myOptions);
	if (zipvalue) searchLocations('');
}
  
function searchLocations(affPhone) {
    if (!affPhone || affPhone=='') affPhone='855-287-6195';
    zipvalue = $('#addressInput').val();
	var zipEntry = document.getElementById('addressInput').value;
	if(!zipEntry || zipEntry=='Zip Code') {
		alert('Please enter valid Zipcode');
		$('#addressInput').focus();
		return false;
	} else {
	  searchLocationsNear(affPhone);
	  return false;
	}
}
	
function searchLocationsNear(affPhone) {
  
	var markers = [
		<?php echo $gmapMarkers; ?>
	];
  
	for (var i = 0; i < markers.length; i++) {
	  
		var marker = markers[i];
	  
		if (i==0) {markerLetter = 'A';classNum='one';}
		if (i==1) {markerLetter = 'B';classNum='two';}
		if (i==2) {markerLetter = 'C';classNum='three';}
		if (i==3) {markerLetter = 'D';classNum='four';}
		if (i==4) {markerLetter = 'E';classNum='five';}
		if (i==5) {markerLetter = 'F';classNum='six';}
		if (i==6) {markerLetter = 'G';classNum='seven';}
		if (i==7) {markerLetter = 'H';classNum='eight';}
		if (i==8) {markerLetter = 'I';classNum='nine';}
		if (i==9) {markerLetter = 'J';classNum='ten';}
		if (i==10) {markerLetter = 'K';classNum='eleven';}
		if (i==11) {markerLetter = 'L';classNum='twelve';}
		if (i==12) {markerLetter = 'M';classNum='thirteen';}
		if (i==13) {markerLetter = 'N';classNum='fourteen';}
		if (i==14) {markerLetter = 'O';classNum='fifteen';}  
		
		var image = new google.maps.MarkerImage('http://www.google.com/mapfiles/marker'+markerLetter+'.png', 
		new google.maps.Size(20, 34), 
		new google.maps.Point(0, 0), 
		new google.maps.Point(10, 34)); 

		var markerImg = 'http://www.google.com/mapfiles/marker'+markerLetter+'.png';
		
		var latlng = new google.maps.LatLng(parseFloat(marker[2]), parseFloat(marker[3]));
		
		if (i==0) var latPrime = latlng;
		
		var locid = marker[0];
		var name = marker[1];
		  
		var marker = new google.maps.Marker({
			position: latlng, 
			map: map,
			icon: image,
			title: name
		});
	
	}

	map.setCenter(latPrime);
	map.setZoom(11);
}

$(document).ready(function(){
	initialize();  
});
</script>

<?php } ?>

<script>

function validateZipcode() {
	var valid = "0123456789-";
	var hyphencount = 0;
	field = document.zipcodeForm.zipcode.value;

	if (field.length!=5 && field.length!=10) {
	alert("Please enter your 5 digit or 5 digit+4 zip code.");
	return false;
	}
	for (var i=0; i < field.length; i++) {
	temp = "" + field.substring(i, i+1);
	if (temp == "-") hyphencount++;
	if (valid.indexOf(temp) == "-1") {
	alert("Invalid characters in your zip code.  Please try again.");
	return false;
	}
	if ((hyphencount > 1) || ((field.length==10) && ""+field.charAt(5)!="-")) {
	alert("The hyphen character should be used with a properly formatted 5 digit+four zip code, like '12345-6789'.   Please try again.");
	return false;
	   }
	}
	document.zipcodeForm.submit();
}


jQuery.fn.quovolver = function(speed, delay) {
	
	/* Sets default values */
	if (!speed) speed = 400;
	if (!delay) delay = 6000;
	
	// If "delay" is less than 4 times the "speed", it will break the effect 
	// If that's the case, make "delay" exactly 4 times "speed"
	var quaSpd = (speed*4);
	if (quaSpd > (delay)) delay = quaSpd;
	
	// Create the variables needed
	var	quote = $(this),
		firstQuo = jQuery(this).filter(':first'),
		lastQuo = jQuery(this).filter(':last'),
		wrapElem = '<div id="quote_wrap"></div>';
	
	// Wrap the quotes
	jQuery(this).wrapAll(wrapElem);
	
	// Hide all the quotes, then show the first
	jQuery(this).hide();
	jQuery(firstQuo).show();
	
	// Set the hight of the wrapper
	jQuery(this).parent().css({height: jQuery(firstQuo).height()});		
	
	// Where the magic happens
	setInterval(function(){
		
		// Set required hight and element in variables for animation
		if(jQuery(lastQuo).is(':visible')) {
			var nextElem = jQuery(firstQuo);
			var wrapHeight = jQuery(nextElem).height();
		} else {
			var nextElem = jQuery(quote).filter(':visible').next();
			var wrapHeight = jQuery(nextElem).height();
		}
		
		// Fadeout the quote that is currently visible
		jQuery(quote).filter(':visible').fadeOut(speed);
		
		// Set the wrapper to the hight of the next element, then fade that element in
		setTimeout(function() {
			jQuery(quote).parent().animate({height: wrapHeight}, speed);
		}, speed);
		
		if(jQuery(lastQuo).is(':visible')) {
			setTimeout(function() {
				jQuery(firstQuo).fadeIn(speed*2);
			}, speed*2);
			
		} else {
			setTimeout(function() {
				jQuery(nextElem).fadeIn(speed);
			}, speed*2);
		}
		
	}, delay);

};

jQuery(document).ready(function(){
	jQuery('.textItem').quovolver();
});

</script>

</div>
</div></div><!-- home > piotr -->

<div id="footer-guarantee-wrap">
	<div id="footer-guarantee">
		<strong>OUR GUARANTEE</strong>
		<span>We value the health of our patients above all else. If you're not fully satisfied, we'll make it right or issue you a full refund.</span>
	</div>
</div>

<div id="footer" class="all"><div id="footer-wrap">
    <div id="menu_popular" class="border-right column">
        <h4>Popular Content</h4>
        <ul>
            <li><a href="http://getstdtested.com/std-testing-options" title="STD Tests and Prices">STD Tests & Prices</a></li>
            <li><a href="http://getstdtested.com/how-std-testing-works" title="How STD Testing Works">How STD Testing Works</a></li>
            <li><a href="http://getstdtested.com/locate-testing-center" title="Find STD Test Location">Find STD Test Location</a></li>
            <li><a href="http://getstdtested.com/std-test-centers" title="STD Test Centers">STD Test Centers</a></li>            
            <li><a href="http://getstdtested.com/symptoms-of-stds" title="Symptoms of STDs">Symptoms of STDs</a></li>
            <li><a href="http://getstdtested.com/sample-results" title="View STD Test Results">View STD Test Results</a></li>
            <li><a href="http://getstdtested.com/blog" title="Blog">Blog</a></li>
            <li><a href="http://getstdtested.com/forum" title="Forum">Forum</a></li>
        </ul><br /><br />
    </div> <!-- /menu_popular -->
    <div id="menu_pinpoint" class="border-right column">
        <h4>Meet Pinpoint MD</h4>
        <ul>
            <li><a href="http://getstdtested.com/meet-ppmd" title="Meet Us">Meet Us</a></li>
            <li><a href="http://getstdtested.com/medical-advisory-board" title="Medical Advisory Board">Medical Advisory Board</a></li>
            <li><a href="http://getstdtested.com/terms-of-service" title="Terms">Terms</a></li>
            <li><a href="http://getstdtested.com/privacy-policy" title="Privacy Policy">Privacy Policy</a></li>
            <li><a href="http://getstdtested.com/site-map" title="Site Map">Site Map</a></li>
            <li><a href="http://getstdtested.com/contact-us" title="Contact Us">Contact</a></li>
        </ul>
        <h4 class="social" style="padding-top: 5px;">
            Stay in Touch: 
            <a href="http://www.facebook.com/pages/GetSTDtested/105243507325" target="_blank" class="fb"><img src="http://getstdtested.com/skin/frontend/enterprise/getstdtested/images/icon_fb.png" /></a> 
            <a href="http://twitter.com/getstdtested" target="_blank" class="twitter"><img src="http://getstdtested.com/skin/frontend/enterprise/getstdtested/images/icon_tweeter.png" /></a>
        </h4><br /><br />
    </div> <!-- /menu_popular -->
    <div id="menu_pinpoint" class="border-right column">
        <h4>Search getSTDtested.com</h4>
		<form action="http://getstdtested.com/custom-search" method="get">
			<input type="text" class="text" id="q" name="q" style="width: 165px; height: 26px; margin: 9px 0 6px 0; background: #f0f8ff; border: 1px solid #1d8bb4;" />
			<input type="submit" class="submit btn_blue_reflection" value="search" style="padding-top: 0; padding-bottom: 0; height: 26px; font-size: 13px; line-height: 25px;" />
		</form>
        <div style="margin: 25px 0 15px 0;"><span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=lXIcpk2QD4YYBvQ8njcKfFXxK1ImaSqHbI4sF4gi3LqZI7fKHC"></script></span></div>
    </div> <!-- /menu_popular -->
    <div id="menu_contact" class="column">
        <div class="box_dark">
            <h4>Test for STDs in Complete Privacy</h4>
            <p>Fast, easy, and as accurate as hospital testing.</p>
            <a class="btn_orange" href="/std-testing-options">order now</a>
            <div class="clear"></div>
        </div>
        <div class="address" style="width: 270px; margin-top: 10px; color: #BFE2FF; font-size: 10px;">
            Per the Annotated Code of Maryland, Health-General Article, &sect;17-215, getSTDtested.com is unable to provide our service within the state of Maryland. If you are a Maryland resident, please call us (866) 749-6269 and we can help you find an alternative testing facility.
        </div>
    </div> <!-- /menu_contact -->
    <div class="clear"></div>
</div></div>


<!-- Google Code for GST Visitors 1 Remarketing List -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1047469408;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "666666";
var google_conversion_label = "w3GLCNrD9AEQ4Lq88wM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1047469408/?label=w3GLCNrD9AEQ4Lq88wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<!-- End of Google Code for GST Visitors 1 Remarketing List -->

<!-- Start of Zopim Live Chat Script -->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=
z.s=d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o
){z.set._.push(o)};$.setAttribute('charset','utf-8');$.async=!0;z.set.
_=[];$.src=('https:'==d.location.protocol?'https://ssl':'http://cdn')+
'.zopim.com/?uBwYwCVwg065nQ32d19kYDqQ6a1l91wt';$.type='text/java'+s;z.
t=+new Date;z._=[];e.parentNode.insertBefore($,e)})(document,'script')
</script>
<!-- End of Zopim Live Chat Script -->

<!-- Begin adBrite, important page views tracking -->
<img src="http://bstats.adbrite.com/adserver/behavioral-data/0?d=47384704;bapid=10251;uid=845986" border="0" hspace="0" vspace="0" width="1" height="1"/> 
<!-- End adBrite, important page views tracking -->

<!-- AdRoll Remarketing Code -->
<script type="text/javascript">
adroll_adv_id = "OBD5PEJZNRCB3PQUJMOZ65";
adroll_pix_id = "V6VV7AXHKZHE3JSOL2EKB5";
(function () {
var oldonload = window.onload;
window.onload = function(){
   __adroll_loaded=true;
   var scr = document.createElement("script");
   var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
   scr.setAttribute('async', 'true');
   scr.type = "text/javascript";
   scr.src = host + "/j/roundtrip.js";
   ((document.getElementsByTagName('head') || [null])[0] ||
    document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
   if(oldonload){oldonload()}};
}());
</script>
<!-- EOF AdRoll Remarketing Code -->
 
	
</body>
</html>
