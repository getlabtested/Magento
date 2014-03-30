<?php
	if (!isset($_SESSION)) {
		session_start();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>About Us | Local STD Testing &amp; At Home STD Testing Kits</title>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<link rel="stylesheet" href="css/styles.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="http://getstdtested.com/media/favicon/default/favicon.ico" type="image/x-icon" />
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="Content-Language" content="en-us" />
	<meta name="robots" content="all" />
	<meta name="keywords" content="std testing, std tests, local std testing, confidential std test, at home std testing kits std testing, std tests, local std testing, confidential std test, at home std testing kits" />
	<meta name="description" content="STD testing is now confidential, quick and easy. Get STD tested at a local STD testing center or take an at home STD test. Select from 8 STD tests &amp; get tested at any local STD testing center. More on STD tests &amp;amp; at home STD testing kits on GetSTDtested" />
</head>

<body>

<?php include_once('affiliate-tracking.php'); ?>


<div id="header">
	<a href="index.php" id="logo" title="Home | STD Testing">STD Testing</a>
</div>

<div id="wrap">

	<h1>About Us</h1>
	<h3>Who We Are</h3>
	<p>GetSTDtested.com is America's leading and most trusted online STD testing clinic – providing you peace of mind through confidential, accurate, and convenient STD testing and STD information. At GetSTDtested.com, we are committed to providing you the means to both gauge your sexual health, and maintain it – by offering pre-test and post-test consultations with medical experts that can help interpret your STD test results, discuss your STD symptoms and, in some cases, even provide treatment. When it comes to your sexual health, we are committed to 100% confidentiality, and we always treat matters personally.</p>
	<h3>What Sets Us Apart</h3>
	<p>Simply put, getSTDtested.com is deeply rooted as an evidence-based medical service offering vs. an online marketing company. The benefit of our emphasis on medical adherence is that getSTDtested.com can be trusted to do no harm and to render the same type of care you would expect from your personal physician. We started the company with a staffed physician who guided educational elements of our site (including getSTDtested.com's forum), our counseling procedures, our test ordering, review, and resulting process; and, responds to the need for personal consult and treatment for individuals with infections. We added a luminary group of medical experts and physicians to assist our efforts to apply the most current STD recommendations, standards and educational tools. Through our partnership with the American Social Health Association (ASHA) GetSTDtested.com was granted the first ever seal of accreditation. We strive to make your STD testing experience as easy as possible, through both our end-to-end online process (ordering through to test results), and our unique at-home std test offering, providing you home std test kits to collect the sample for both Gonorrhea and Chlamydia from the comfort of your own home and then mail it to a national lab for assured quality. And lastly, we listen hard and we take action to continually improve.</p>
	<h3>Our History</h3>
	<p>GetSTDtested.com was born from a history of commitment to excellence – proven by our founder, Tracey Powell. Prior to founding GetSTDtested.com in 2009, Mr. Powell founded Home Access Health in 1993 – currently the only company approved by the FDA to provide at-home STD testing for both HIV and Hepatitis C. At GetSTDtested.com, our mission is to continue this history of excellence and set the Gold Standard for STD testing and awareness.</p>
	<h3>Our Commitment to Privacy</h3>
	<p>Your sexual health is a private matter and we treat it as such with 100% confidentiality. We will never share any of your information including your STD test results, other than when a positive result is required by the State Health Department for statistical purposes. We are solely in the business of getting you peace of mind - so test with confidence. Get STD tested today by the experts at GetSTDtested.com.</p>

	<div id="tabs">
		<ul>
			<li><a href="how-it-works">How It Works<div></div></a></li>
			<li><a href="std-tests">STD Tests<div></div></a></li>
			<li><a href="find-testing-center">Find Testing Center<div></div></a></li>
			<li><a href="common-questions">Common Questions<div></div></a></li>
			<li><a href="the-lab-experience">The Lab Experience<div></div></a></li>
			<li><a href="about-us" class="current">About Us<div></div></a></li>
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
