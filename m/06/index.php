<?php
if (!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION['mobile_version'])) {

	$_SESSION['mobile_version'] = 6;

}

if ($_POST) {

	foreach ($_POST as $k=>$v) {
	
		$_SESSION[$k] = $v;
	
	}

}

//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";

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

<!-- Google Website Optimizer Tracking Script -->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['gwo._setAccount', 'UA-10462432-2']);
  _gaq.push(['gwo._trackPageview', '/2295222754/test']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<!-- End of Google Website Optimizer Tracking Script -->
	
<script type="text/javascript">

function is_int(value){
   for (i = 0 ; i < value.length ; i++) {
      if ((value.charAt(i) < '0') || (value.charAt(i) > '9')) return false 
    }
   return true;
}

var basicPackage = 150;

var ultimatePackage = 229;

var indiSkuArr = new Array();
	indiSkuArr[0] = 'hiv-lab';
	indiSkuArr[1] = 'chlamydia-gonorrhea-lab';
	indiSkuArr[2] = 'oral-genital-herpes-lab';
	indiSkuArr[3] = 'syphilis-lab';
	indiSkuArr[4] = 'hepatitis-b-lab';
	indiSkuArr[5] = 'hepatitis-c-lab';
	indiSkuArr[6] = 'hiv-early-detection-lab';

var indiTestOrig = new Array();
	indiTestOrig[0] = 79;
	indiTestOrig[1] = 149;
	indiTestOrig[2] = 149;
	indiTestOrig[3] = 89;
	indiTestOrig[4] = 89;
	indiTestOrig[5] = 89;
	indiTestOrig[6] = 179;
	
	var homeSkuArr = new Array();
	homeSkuArr[0] = 'hiv-home';
	homeSkuArr[1] = 'chlamydia-gonorrhea-home';
	homeSkuArr[2] = 'trichomoniasis-home';
	
var homeTestOrig = new Array();
	homeTestOrig[0] = 99;
	homeTestOrig[1] = 149;
	homeTestOrig[2] = 199;
	
	
	
var cartArr = new Array();
	

function updateWidgetTotal(el,id) {
		
	if (typeof total == 'undefined') {
		
		total = 0;
	
	}
	
	var discount = 0;
	
	if (document.getElementById(el).type == 'radio') {
	
	
		if (document.getElementById('hiv-early-detection-lab').checked == false) {
	
			total = 0;
			
			price = 0;
			
			cartArr = new Array();
		
		} else {
		
			total = 0;
		
			price = indiTestOrig[6];
				
		}
		
		<?php //if (!Mage::getSingleton('core/session')->getIsNnr()) { ?>
		
		document.getElementById('package').value = id;
	
		for (i = 0; i < indiSkuArr.length; i++) {
		
			if (indiSkuArr[i] != 'hiv-early-detection-lab') {
		
			document.getElementById(indiSkuArr[i]).checked = false;
			document.getElementById(indiSkuArr[i]).value = indiTestOrig[i];
			
			}
			
		}
			
		// for (i = 0; i < homeSkuArr.length; i++) {
			// document.getElementById(homeSkuArr[i]).checked = false;
			// document.getElementById(homeSkuArr[i]).value = homeTestOrig[i];
		// }
	
		if (document.getElementById(el).value == 0) {
	
			document.getElementById('widget_total').innerHTML = "Select Tests";
			
		} else {
		
			price = parseInt(document.getElementById(el).value) + price;
	
			price = parseInt(price);
		
			document.getElementById('widget_total').innerHTML = "$"+price;	
			
			if (el == 'complete_package') {
			
				document.getElementById('complete_package_hidden').value = price;
				document.getElementById('expert_package_hidden').value = 0;
			
			} else {
			
				document.getElementById('expert_package_hidden').value = price;
			
			}
		
		}
		
		<?php //} else  { ?>
			
		// document.getElementById('package').value = id;
	
		// for (i = 0; i < indiSkuArr.length; i++) {
			
			// if (indiSkuArr[i] != 'hiv-early-detection-lab') {
		
			// document.getElementById(indiSkuArr[i]).checked = false;
			// document.getElementById(indiSkuArr[i]).value = indiTestOrig[i];
			
			// }
			
		// }
			
		// for (i = 0; i < homeSkuArr.length; i++) {
			// document.getElementById(homeSkuArr[i]).checked = false;
			// document.getElementById(homeSkuArr[i]).value = homeTestOrig[i];
		// }
	   	
	   	// total = 125;
	   	
	   	// for (var i = 0; i < cartArr.length; i++) {
    			
    			// if (cartArr[i] == 'hiv-home'){
    			
    				// total = 99;
    			
    			// }
			// }
	   	
	   	
	   	// document.getElementById('widget_total').innerHTML = '$'+total;
	   	
	   <?php //} ?>
	
	   
		
	} else {
		
		re = 0;
	
		if (el != 'hiv-early-detection-lab' && document.getElementById('expert_package').checked == true && document.getElementById('hiv-early-detection-lab').checked == true) {
	
			document.getElementById('expert_package_hidden').value = 0;
		
			document.getElementById('expert_package').checked = false;
			
			document.getElementById('hiv-early-detection-lab').checked = false;
			
			document.getElementById('hiv-early-detection-lab').value = indiTestOrig[6];
			
			document.getElementById('package').value = "";
			
			total = 0;
		
		}
		
		if (el != 'hiv-early-detection-lab' && document.getElementById('expert_package').checked == true) {
		
			document.getElementById('expert_package_hidden').value = 0;
		
			document.getElementById('expert_package').checked = false;
			
			document.getElementById('package').value = "";
			
		}
		
		/*
if (el == 'hiv-early-detection-lab' && document.getElementById('expert_package').checked == true) {
		
			if (document.getElementById('hiv-early-detection-lab').value < 0) {	
					
				total = 418;
				
			} else {
			
				total = 229;
			
			}
		
		}
*/
		
	
		price = document.getElementById(el).value;
	
		price = parseInt(price);

		if(el.indexOf('home')> 0) {
		
			for (i = 0; i < cartArr.length; i++) { 
			
				if (cartArr[i].indexOf('lab')>0) {
								
				 	//document.getElementById(cartArr[i]+"-cart").style.display = "none";
				
					re = 1;
				
				}
			
			}
		
		}
		
		if(el.indexOf('lab')> 0) {
		
			for (i = 0; i < cartArr.length; i++) { 
			
				if (cartArr[i].indexOf('home')>0) {
				
					//document.getElementById(cartArr[i]+"-cart").style.display = "none";
				
					re = 1;
				
				}
			
			}
		
		}
		
		if (re == 1) {
		
			cartArr = new Array();
		
		}
				
		if (indiSkuArr.indexOf(el) >= 0) {
					
			// for (i = 0; i < homeSkuArr.length; i++) {
			
				// if (document.getElementById(homeSkuArr[i]).checked == true) {
					// document.getElementById(homeSkuArr[i]).checked = false;
					// document.getElementById(homeSkuArr[i]).value = homeTestOrig[i];
					// total = 0;
				// }
			// }
		
		} else {
		
			document.getElementById('expert_package_hidden').value = 0;
		
			document.getElementById('expert_package').checked = false;
			
			document.getElementById('package').value = "";
					
			for (i = 0; i < indiSkuArr.length; i++) {
				if (document.getElementById(indiSkuArr[i]).checked == true) {
					document.getElementById(indiSkuArr[i]).checked = false;
					document.getElementById(indiSkuArr[i]).value = indiTestOrig[i];
					total = 0;
				}
			}
		
		}
	
		if (price < 0) {
		
			document.getElementById(el).value = price + (price*-2);
			
			for (key in cartArr) {
    			if (cartArr[key] == el) {
        			cartArr.splice(key, 1);
    			}
			}
			
				
		} else {
		
			document.getElementById(el).value = price - (price*2);
			
			cartArr.push(el);
	
		}
		
		
		if (el == 'hiv-early-detection-lab' && document.getElementById('expert_package').checked == true) {
		
			if (document.getElementById('hiv-early-detection-lab').checked == false) {	
					
				total = 418;
				
			} else {
			
				total = 229;
			
			}
			
			total = total + price;
		
		} else {
		
		total = total + price;
		
		}
		
			
	   	
	   	   
	
	   document.getElementById('widget_total').innerHTML = '$'+(total);
	
	}
	
}

function checkEmpty() {
	
	if (cartArr.length == 0 && !document.getElementById('expert_package').checked) {
		
		alert('Please select STD tests before checkout.');
		
		return false;
		
	}
	
	document.getElementById('orderWidget').submit();
	return true;
	
}

function turnOff (el){

	
}

function toggleCartElement(el) {

	if (el == 'expert_package') {
		
		//document.getElementById('expert_package-cart').style.display = 'block';
		
		for (i = 0; i < indiSkuArr.length; i++) {
			//document.getElementById(indiSkuArr[i]+'-cart').style.display = "none";
		}
		
		//for (i = 0; i < homeSkuArr.length; i++) {
			//document.getElementById(homeSkuArr[i]+'-cart').style.display = "none";
		//}
			
	} else {
	
	
	//document.getElementById('expert_package-cart').style.display = 'none';

	elId = el+'-cart';

	/*
if (document.getElementById(elId).style.display == 'none') {
	
	var cartList = document.getElementById('ow_list');
		
	document.getElementById(elId).style.display = 'block';
	
	} else {
	
	document.getElementById(elId).style.display = 'none';
	
	}
*/
	
	}
	
}

function submitenter(e)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;

if (keycode == 13)
   {
   document.getElementById('location_submit_button').click();
   return false;
   }
else
   return true;
}

</script>
	
</head>

<body>

<?php include_once('affiliate-tracking.php'); ?>


<div id="header">
	<a href="index.php" id="logo" title="Home | STD Testing">STD Testing</a>
</div>

<div id="wrap">

	<h2 class="home">100% PRIVATE, AFFORDABLE, ACCURATE</h2>
	<div style="padding: 0 0 6px 0; background: transparent url('images/photo-doc.jpg') right top no-repeat;">
		<h1 class="home">STD TESTING</h1>
		<p>Get the peace of mind you need<br />from the most respected, most<br />convenient, most private<br />STD TESTING service available.<br /><strong>All for 50% less than<br />a&nbsp;doctor's office visit.</strong></p>
	</div>
	
	<form id="orderWidget" method="post" action="http://getstdtested.com/customroute/index/checkoutmobile">
	<div id="tests-complete-pack">
		<div id="tests-header">
			<span>COMPLETE</span> STD TESTS PACKAGE
		</div>
		<div id="tests-content">
			<ul class="fleft">
				<li>HIV Standard</li>
				<li>Chlamydia</li>
				<li>Gonorrhea</li>
				<li>Syphilis</li>
			</ul>
			<ul class="fleft">
				<li>Oral Herpes</li>
				<li>Genital Herpes</li>
				<li>Hepatitis B</li>
				<li>Hepatitis C</li>
			</ul>
			<div class="cboth"></div>
		</div>
		<div id="tests-footer">
			<div id="tests-price">$229</div>

			<input type="radio" id="expert_package" value="229" onClick="updateWidgetTotal(this.id,14);toggleCartElement(this.id);" name="testPackage" style="float: left; margin-top: 24px;" />

			<a href="" onclick="javascript:checkEmpty(); return false;" id="b-add-to-cart">ADD TO CART</a>
			<input type="hidden" id="expert_package_hidden" name="expert_package_hidden" value="">
			<input type="hidden" name="mobile_version" value="4">
			<div id="tests-savings">Over <strong>$400</strong> savings compared to individual tests</div>
		</div>
	</div>
	
	<div id="tests-individual">
		<div id="tests-header">
			<span>INDIVIDUAL</span> STD TESTS
		</div>
		<div id="tests-content">
			<ul>
				<li><input type="checkbox" value="79.0000" id="hiv-lab" onClick="updateWidgetTotal(this.id,11);toggleCartElement(this.id);" name="indiTest[hiv-lab]" /><label for="hiv-lab">HIV Standard</label></li>
				<li class="price">$79</li>
				<li><input type="checkbox" value="149.0000" id="chlamydia-gonorrhea-lab" onClick="updateWidgetTotal(this.id,40);toggleCartElement(this.id);" name="indiTest[chlamydia-gonorrhea-lab]" /><label for="chlamydia-gonorrhea-lab">Chlamydia &amp; Gonorrhea</label></li>
				<li class="price">$149</li>
				<li><input type="checkbox" value="149.0000" id="oral-genital-herpes-lab" onClick="updateWidgetTotal(this.id,42);toggleCartElement(this.id);" name="indiTest[oral-genital-herpes-lab]" /><label for="oral-genital-herpes-lab">Oral &amp; Genital Herpes</label></li>
				<li class="price">$149</li>
				<li><input type="checkbox" value="89.0000" id="syphilis-lab" onClick="updateWidgetTotal(this.id,12);toggleCartElement(this.id);" name="indiTest[syphilis-lab]" /><label for="syphilis-lab">Syphilis</label></li>
				<li class="price">$89</li>
				<li><input type="checkbox" value="89.0000" id="hepatitis-b-lab" onClick="updateWidgetTotal(this.id,7);toggleCartElement(this.id);" name="indiTest[hepatitis-b-lab]" /><label for="hepatitis-b-lab">Hepatitis B</label></li>
				<li class="price">$89</li>
				<li><input type="checkbox" value="89.0000" id="hepatitis-c-lab" onClick="updateWidgetTotal(this.id,8);toggleCartElement(this.id);" name="indiTest[hepatitis-c-lab]" /><label for="hepatitis-c-lab">Hepatitis C</label></li>
				<li class="price">$89</li>
				<li><input type="checkbox"  value="179.0000" id="hiv-early-detection-lab" onClick="updateWidgetTotal(this.id,13);toggleCartElement(this.id);" name="indiTest[hiv-early-detection-lab]" /><label for="hiv-early-detection-lab">HIV Early Detection *</label></li>
				<li class="price">$179</li>
			</ul>
			<div class="cboth"></div>
		</div>
		<div id="tests-footer">			
			<div id="order-total">
				ORDER TOTAL
				<span id="order-total-price"><div id="widget_total">$0</div></span>
			</div>
			<!-- <input type="button" onclick="checkEmpty();" class="submit btn_orange_32_reflection" value="continue" style="width: 125px;" /> -->
			<input type="hidden" id="package" name="package" value="">
			<input type="hidden" name="mobile_version" value="4">
			<div class="cboth"></div>
			<a href="" onclick="javascript:checkEmpty(); return false;" id="b-add-to-cart">ADD SELECTED TESTS TO CART</a>
			<div class="cboth"><br /></div>
		</div>
	</div>
	</form>

	<p class="acenter" style="padding-top: 0;">
		<h3 class="home">QUESTIONS? OR TO ORDER BY PHONE</h3>
		<div id="b-orange-home"><span>CALL</span> 877-647-9251</div>
	</p>

	<script type="text/javascript">	
		p = '<?php echo $phone; ?>';

		if (p.length > 6) {	
			document.getElementById('b-orange-home').innerHTML = '<span>CALL</span> ' + p;
		}	
	</script>

	<p id="quote">
		&nbsp;&nbsp;My doctor wouldn't have been able to see<br />me for 2 months. <strong>I was able to get same day testing</strong> through your service and my test results came back sooner than 3 days.<br />
		<span>Male, 36 from Illinois</span>
	</p>

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

	<div class="cboth"><br /></div>

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
