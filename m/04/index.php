<?php
if (!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION['mobile_version'])) {

	$_SESSION['mobile_version'] = 4;

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>STD Testing | Local STD Testing &amp; At Home STD Testing Kits</title>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<link rel="stylesheet" href="css/styles.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="http://getstdtested.com/media/favicon/default/favicon.ico" type="image/x-icon" />
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="Content-Language" content="en-us" />
	<meta name="robots" content="all" />
	<meta name="keywords" content="std testing, std tests, local std testing, confidential std test, at home std testing kits std testing, std tests, local std testing, confidential std test, at home std testing kits" />
	<meta name="description" content="STD testing is now confidential, quick and easy. Get STD tested at a local STD testing center or take an at home STD test. Select from 8 STD tests &amp; get tested at any local STD testing center. More on STD tests &amp;amp; at home STD testing kits on GetSTDtested" />

<!-- Google Website Optimizer Control Script -->
<!-- End of Google Website Optimizer Tracking Script -->
	
</head>

<body>

<?php include_once('affiliate-tracking.php'); ?>


<div id="header">
	<a href="index.php" id="logo" title="Home | STD Testing">STD Testing</a>
</div>

<div id="wrap">

	<h2 class="home">100% PRIVATE, AFFORDABLE, ACCURATE</h2>
	<h1 class="home">STD TESTING</h1>
	<p>Get the peace of mind you need from the most respected, most convenient, most private STD TESTING service available. <strong>All for 50% less than a&nbsp;doctor's office visit.</strong></p>

	<div id="tabs">
		<ul>
			<li><a href="how-it-works">How It Works<div></div></a></li>
			<li><a href="std-tests">STD Tests<div></div></a></li>
			<li><a href="find-testing-center">Find Testing Center<div></div></a></li>
			<li><a href="common-questions">Common Questions<div></div></a></li>
			<li><a href="the-lab-experience">The Lab Experience<div></div></a></li>
			<li><a href="about-us">About Us<div></div></a></li>
		</ul>
	</div>

	<p class="acenter">
		<div id="b-orange"><span>CALL</span> 877-647-9251</div>
		<a href="std-tests" id="b-blue">ORDER ONLINE</a>
		<div class="cboth"></div>
	</p>

	<script type="text/javascript">	
		p = '<?php echo $phone; ?>';

		if (p.length > 6) {	
			document.getElementById('b-orange').innerHTML = '<span>CALL</span> ' + p;
		}	
	</script>

</div>

<div id="footer">
	<p id="trustbuilders">
		<span>4.5/5</span> star customer reviews
	</p>
	<p>
		<a href="http://getstdtested.com/?mobile=false" id="full-site">View Full Site</a><br />
		<a href="privacy-policy">Privacy Policy</a> &nbsp; &bull; &nbsp; <a href="terms-of-service">Terms of Service</a><br />
		&copy; 2012 getSTDtested.com. All rights reserved.
	</p>
</div>


<script language="javascript" type="text/javascript"> 
	function hideURLbar() {
		window.scrollTo(0, 1);
	}
	if (navigator.userAgent.indexOf('iPhone') != -1) {
		addEventListener("load", function(){
		setTimeout(hideURLbar, 0);}, false);
	}
</script>

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


</body>
</html>
