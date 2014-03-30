<?php

	// require '../../app/Mage.php';
 
	// if (!Mage::isInstalled()) {
		// echo "Application is not installed yet, please complete install wizard first.";
		// exit;
	// }

	// $_SERVER['SCRIPT_NAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_NAME']);
	// $_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_FILENAME']);

	// Mage::app();
	// Mage::app()->setCurrentStore(1);
 
?>
	
<?php

//echo "<pre>";  print_r(Mage::getModel('core/session')->getData()); echo "</pre>";

// $this->resetCart();

// Mage::getSingleton('core/session')->setCartArr(array());

// $_products = $this->getProducts();

// $state = Mage::getSingleton('core/session')->getOrderState();

// $sZip = Mage::getSingleton('core/session')->getZip();

// if ($sZip) {

	// $sesZip = $sZip;

// } else {

	// $sesZip = 'Zip Code';

// }

//echo "<pre>"; print_r(Mage::getSingleton('core/session')->getData()); echo "</pre>"; 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Get STD Tested</title>

	<link rel="stylesheet" href="css/styles.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="images/favicon.ico" />

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Language" content="en-us" />

	<meta name="robots" content="all" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />

	<!-- BEGIN GOOGLE ANALYTICS CODE -->
	<script type="text/javascript">
	//<![CDATA[
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ga);
		})();
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-10462432-1']);
		_gaq.push(['_trackPageview']);
	//]]>
	</script>
	<!-- END GOOGLE ANALYTICS CODE -->

	<!-- ClickTale Top part -->
	<script type="text/javascript">
	var WRInitTime=(new Date()).getTime();
	</script>
	<!-- ClickTale end of Top part -->

	<!-- Fancybox for Test Recommender -->
	<link rel="stylesheet" type="text/css" href="http://getstdtested.com/test-recommender/jquery.fancybox-1.3.4.css" media="screen" />
	<script type="text/javascript" src="http://getstdtested.com/skin/frontend/default/getstdtested/js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="http://getstdtested.com/test-recommender/jquery.fancybox-1.3.4.pack.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#test-recommender").fancybox({
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


<script type="text/javascript">

function is_int(value){
   for (i = 0 ; i < value.length ; i++) {
      if ((value.charAt(i) < '0') || (value.charAt(i) > '9')) return false 
    }
   return true;
}

function handlerFunction(){
	
	document.getElementById('ajax-loader-gif').style.display = 'block'; 
				
	if ($("zip_code").value.length != 5 ||is_int($("zip_code").value) === false) {
		
		alert('Please enter a valid 5 digit zip code.');
		document.getElementById('ajax-loader-gif').style.display = 'none'; 
		return false;
		
	}
		
	
 
        var request = new Ajax.Request(
            '<?php //echo $this->getUrl("http://getstdtested.com/medivo/local/getlabsorder") ?>',
            {
                method: 'post',
                onComplete: function(transport){ 
 
                    var jsonResponse=transport.responseText;

                    if(jsonResponse.error){
                        alert("Error Occured");
                        return false;
                    }
                    else{
                    	document.getElementById('ajax-loader-gif').style.display = 'none';
                        document.getElementById("location_results").innerHTML =jsonResponse;
                    }
                },
                parameters: Form.serialize($("location_form"))            
           }
        );
}


var basicPackage = 150;
var ultimatePackage = 249;

var indiTestOrig = new Array();
	indiTestOrig[0] = <?php echo round($_products['chlamydia-lab']['price']);?>;
	indiTestOrig[1] = <?php echo round($_products['gonorrhea-lab']['price']);?>;
	indiTestOrig[2] = <?php echo round($_products['hiv-lab']['price']);?>;
	indiTestOrig[3] = <?php echo round($_products['syphilis-lab']['price']);?>;
	indiTestOrig[4] = <?php echo round($_products['oralherpes-lab']['price']);?>;
	indiTestOrig[5] = <?php echo round($_products['genitalherpes-lab']['price']);?>;
	indiTestOrig[6] = <?php echo round($_products['hepatitis-b-lab']['price']);?>;
	indiTestOrig[7] = <?php echo round($_products['hepatitis-c-lab']['price']);?>;
	
var homeTestOrig = new Array();
	homeTestOrig[0] = <?php echo round($_products['chlamydia-home']['price']);?>;
	homeTestOrig[1] = <?php echo round($_products['trichomoniasis-home']['price']);?>;
	homeTestOrig[2] = <?php echo round($_products['gonorrhea-home']['price']);?>;
	homeTestOrig[3] = <?php echo round($_products['hiv-home']['price']);?>;
	
var indiSkuArr = new Array();
	indiSkuArr[0] = 'chlamydia-lab';
	indiSkuArr[1] = 'gonorrhea-lab';
	indiSkuArr[2] = 'hiv-lab';
	indiSkuArr[3] = 'syphilis-lab';
	indiSkuArr[4] = 'oralherpes-lab';
	indiSkuArr[5] = 'genitalherpes-lab';
	indiSkuArr[6] = 'hepatitis-b-lab';
	indiSkuArr[7] = 'hepatitis-c-lab';
	
var homeSkuArr = new Array();
	homeSkuArr[0] = 'chlamydia-home';
	homeSkuArr[1] = 'trichomoniasis-home';
	homeSkuArr[2] = 'gonorrhea-home';
	homeSkuArr[3] = 'hiv-home';
	
var cartArr = new Array();
	

function updateWidgetTotal(el,id) {
		
	if (typeof total == 'undefined') {
		
		total = 0;
	
	}
	
	var discount = 0;
	
	if (document.getElementById(el).type == 'radio') {
	
	
		total = 0;
		
		price = 0;
		
		cartArr = new Array();
		
		<?php //if (!Mage::getSingleton('core/session')->getIsNnr()) { ?>
		
		document.getElementById('package').value = id;
	
		for (i = 0; i < indiSkuArr.length; i++) {
			document.getElementById(indiSkuArr[i]).checked = false;
			document.getElementById(indiSkuArr[i]).value = indiTestOrig[i];
		}
			
		for (i = 0; i < homeSkuArr.length; i++) {
			document.getElementById(homeSkuArr[i]).checked = false;
			document.getElementById(homeSkuArr[i]).value = homeTestOrig[i];
		}
	
		if (document.getElementById(el).value == 0) {
	
			document.getElementById('widget_total').innerHTML = "Select Tests";
			
		} else {
		
			price = document.getElementById(el).value;
	
			price = parseInt(price);
		
			document.getElementById('widget_total').innerHTML = "$"+price;	
			
			if (el == 'complete_package') {
			
				document.getElementById('complete_package_hidden').value = price;
				document.getElementById('expert_package_hidden').value = 0;
			
			} else {
			
				document.getElementById('expert_package_hidden').value = price;
				document.getElementById('complete_package_hidden').value = 0;
			
			}
		
		}
		
		<?php //} else  { ?>
			
		document.getElementById('package').value = id;
	
		for (i = 0; i < indiSkuArr.length; i++) {
			document.getElementById(indiSkuArr[i]).checked = false;
			document.getElementById(indiSkuArr[i]).value = indiTestOrig[i];
		}
			
		for (i = 0; i < homeSkuArr.length; i++) {
			document.getElementById(homeSkuArr[i]).checked = false;
			document.getElementById(homeSkuArr[i]).value = homeTestOrig[i];
		}
	   	
	   	total = 125;
	   	
	   	for (var i = 0; i < cartArr.length; i++) {
    			
    			if (cartArr[i] == 'hiv-home'){
    			
    				total = 105;
    			
    			}
			}
	   	
	   	// if (cartArr.length == 0) {
// 	   		
	   		// total = 0;
// 	   		
	   	// }
	   	
	   	document.getElementById('widget_total').innerHTML = '$'+total;
	   	
	   <?php //} ?>
	
	   
		
	} else {
		
		re = 0;
	
		document.getElementById('expert_package_hidden').value = 0;
		document.getElementById('complete_package_hidden').value = 0;
		
		document.getElementById('expert_package').checked = false;
		document.getElementById('complete_package').checked = false;
		
		document.getElementById('package').value = "";
	
		price = document.getElementById(el).value;
	
		price = parseInt(price);

		if(el.indexOf('home')> 0) {
		
			for (i = 0; i < cartArr.length; i++) { 
			
				if (cartArr[i].indexOf('lab')>0) {
								
				 	document.getElementById(cartArr[i]+"-cart").style.display = "none";
				
					re = 1;
				
				}
			
			}
		
		}
		
		if(el.indexOf('lab')> 0) {
		
			for (i = 0; i < cartArr.length; i++) { 
			
				if (cartArr[i].indexOf('home')>0) {
				
					document.getElementById(cartArr[i]+"-cart").style.display = "none";
				
					re = 1;
				
				}
			
			}
		
		}
		
		if (re == 1) {
		
			cartArr = new Array();
		
		}
				
		if (indiSkuArr.indexOf(el) >= 0) {
					
			for (i = 0; i < homeSkuArr.length; i++) {
				if (document.getElementById(homeSkuArr[i]).checked == true) {
					document.getElementById(homeSkuArr[i]).checked = false;
					document.getElementById(homeSkuArr[i]).value = homeTestOrig[i];
					total = 0;
				}
			}
		
		} else {
					
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
		
		<?php //if (!Mage::getSingleton('core/session')->getIsNnr()) { ?>
				
		if (cartArr.length == 2 && el.indexOf('lab') > 0) {
		
			discount = 30;
					
		} 
		
		if (cartArr.length == 3 && el.indexOf('lab') > 0) {
		
			discount = 75;
					
		}
		
		if (cartArr.length == 4 && el.indexOf('lab') > 0) {
		
			discount = 165;
					
		}
		
		if (cartArr.length == 5 && el.indexOf('lab') > 0) {
		
			discount = 205;
					
		}
		
		if (cartArr.length == 6 && el.indexOf('lab') > 0) {
		
			discount = 295;
					
		}
		
		if (cartArr.length == 7 && el.indexOf('lab') > 0) {
		
			discount = 385;
					
		}
		
		if (cartArr.length == 8 && el.indexOf('lab') > 0) {
		
			discount = 475;
					
		}
		
		
		if (cartArr.length == 2 && el.indexOf('home') > 0 ) {
		
			for (var i = 0; i < cartArr.length; i++) {
    			
    			if (cartArr[i] != 'trichomoniasis-home'){
    			
    				discount = 45;
    			
    			}
			}

		}
		
		if (cartArr.length == 3 && el.indexOf('home') > 0 ) {
		
			for (var i = 0; i < cartArr.length; i++) {
    			
    			if (cartArr[i] != 'trichomoniasis-home'){
    			
    				discount = 106;
    			
    			}
			}
		
		}
		
		if (cartArr.length == 2 && el.indexOf('home') > 0 ) {
		
			for (var i = 0; i < cartArr.length; i++) {
    			
    			if (cartArr[i] == 'trichomoniasis-home'){
    			
    				discount = 70;
    			
    			}
			}

		}
		
		if (cartArr.length == 3 && el.indexOf('home') > 0 ) {
		
			for (var i = 0; i < cartArr.length; i++) {
    			
    			if (cartArr[i] == 'trichomoniasis-home'){
    			
    				discount = 135;
    			
    			}
			}

		}
		
		if (cartArr.length == 4 && el.indexOf('home') > 0 ) {
		
			discount = 196;
		
		}
		
	
	   total = total + price;	
	   
	   <?php //} else  { ?>
	   	
	   	total = 125;
	   	
	   	for (var i = 0; i < cartArr.length; i++) {
    			
    			if (cartArr[i] == 'hiv-home'){
    			
    				total = 105;
    			
    			}
			}
	   	
	   	if (cartArr.length == 0) {
	   		
	   		total = 0;
	   		
	   	}
	   	
	   <?php //} ?>
	
	   document.getElementById('widget_total').innerHTML = '$'+(total-discount);
	
	}
	
}

function checkEmpty() {
	
	if (cartArr.length == 0 && !document.getElementById('expert_package').checked && !document.getElementById('expert_package').checked && !document.getElementById('complete_package').checked) {
		
		alert('Please select STD tests before checkout.');
		
		return false;
		
	}
	
	
	
	document.getElementById('orderWidget').submit();
	return true;
	
}

function turnOff (el){

	

}

function toggleCartElement(el) {

	if (el == 'complete_package') {
		
		document.getElementById('expert_package-cart').style.display = 'none';
		document.getElementById('complete_package-cart').style.display = 'block';
		
		for (i = 0; i < indiSkuArr.length; i++) {
			document.getElementById(indiSkuArr[i]+'-cart').style.display = "none";
		}
		
		for (i = 0; i < homeSkuArr.length; i++) {
			document.getElementById(homeSkuArr[i]+'-cart').style.display = "none";
		}
		
		
	
	} else if (el == 'expert_package') {
		
		document.getElementById('complete_package-cart').style.display = 'none';
		document.getElementById('expert_package-cart').style.display = 'block';
		
		for (i = 0; i < indiSkuArr.length; i++) {
			document.getElementById(indiSkuArr[i]+'-cart').style.display = "none";
		}
		
		for (i = 0; i < homeSkuArr.length; i++) {
			document.getElementById(homeSkuArr[i]+'-cart').style.display = "none";
		}
			
	} else {
	
	document.getElementById('complete_package-cart').style.display = 'none';
	
	document.getElementById('expert_package-cart').style.display = 'none';

	elId = el+'-cart';

	if (document.getElementById(elId).style.display == 'none') {
	
	var cartList = document.getElementById('ow_list');
		
	document.getElementById(elId).style.display = 'block';
	
	} else {
	
	document.getElementById(elId).style.display = 'none';
	
	}
	
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


<div class="wrap">

	<div id="header">
		<div id="logo"><a href="#" title="Home | Get STD Tested">Get STD Tested</a></div>
		<div id="nav">
			<a href="#how">How it Works</a> &nbsp;|&nbsp;
			<a href="#getting-results">Getting Results</a> &nbsp;|&nbsp;
			<a href="#get-tested">Get Tested</a> &nbsp;|&nbsp; or&nbsp;
			<span id="phone">Call 866-749-6269</span>
		</div>
	</div>

	<div id="banner">
		<h1>Get Ahead of the Dating Game!</h1>
		<h2>Be prepared!</h2>
		<h3>Join 1000's of tested singles!</h3>
		<ul>
			<li>100% Confidential STD Testing</li>
			<li>Highest Quality and Accurate Testing</li>
			<li>Treatment Available in Most Cases</li>
		</ul>
		<div id="b-get-tested"><a href="#get-tested" title="Get Tested Today">Get Tested Today</a></div>
	</div>
	
	<div class="canvas">

		<div id="trustbuilders">
			<p>Trusted by customers, the FDA and the sexual community</p>
			<p>Average Customer Review &ndash; <strong>4.5 out of 5 Stars</strong></p>
		</div>
		
		<div class="quote">
			<p>My doctor wouldn't have been able to see me for 2 months.<br /><span>I was able to get same day testing</span> through your service and<br />my test results came back sooner than 3 days.</p>
			<div>- Male, 36 from Illinois</div>
		</div>

		<a name="how"></a>
		<h2 id="h-how-it-works">How it Works?</h2>
		
		<ul id="how-it-works">
			<li id="how-it-works-1">
				<strong>1. Choose Your Tests</strong>
				<p>Select which STDs to test for and whether you'd prefer to be tested at home or at one of our 4,000 convenient lab locations. We accept credit / debit cards, e-checks and anoymous cash drop-off.</p>
			</li>
			<li id="how-it-works-2">
				<strong>2. Take The Test</strong>
				<p>Visit our nearest lab - we have over 4,000 locations - or take the test from the comfort of your own home and send the sample in.</p>
			</li>
			<li id="how-it-works-3">
				<strong>3. Check Your Results</strong>
				<p>Your test results will be ready within 3-5 days (faster than a doctor's office) and you'll be notified the second they are available. You can then view them via secure online portal or discuss them over the phone.</p>
			</li>
			<li id="how-it-works-4">
				<strong>4. Treatment Options</strong>
				<p>If the news isn't good, you still have options. Discuss your test with our in-house physicians to help interpret test results and answer questions. From medication to antibiotics, get private treatment.</p>
			</li>
		</ul>
		
		<h2 id="h-medical-board">Meet Our Medical Advisory Board &ndash; Accessible doctors focused on delivering accurate and private STD testing and treatment</h2>
		
		<div id="medical-board">

			<div class="medical-board-col">
				<img src="images/medical-board-photo-1.jpg" width="240" height="175" border="0" alt="" />
				<h4>H. Hunter Handsfield, MD</h4>
				<p>With over 30+ years of experience and 250 publications under his belt, Dr. Handsfield has played an integral role in developing modern day STD prevention strategies.</p>
			</div>
			
			<div class="medical-board-col">
				<img src="images/medical-board-photo-2.jpg" width="240" height="175" border="0" alt="" />
				<h4>Barbara Van Der Pol, PhD, MPH</h4>
				<p>Dr. Van Der Pol is a leading advisor for the Centers for Disease Control (CDC) and the National Chlamydia Coalition, performing cutting-edge STD research.</p>
			</div>
			
			<div class="medical-board-col">
				<img src="images/medical-board-photo-3.jpg" width="240" height="175" border="0" alt="" />
				<h4>Neil S. Skolnik, MD</h4>
				<p>Dr. Skolnik is a well-known presenter and recent recipient of the "Top Doctor" Award in Family Medicine by Philadelphia Magazine, regularly contributing to CDC editorial.</p>
			</div>

		</div>
		
		<a href="#get-tested" title="Get Tested Today" id="b-get-tested-today">Get Tested Today</a>

		<div class="phone-cta">Questions? Call 866-749-6269</div>
		
		<div class="quote">
			<p>I would recommend you and I will use your services again.<br /><span>I appreciate the convenience, confidentiality, and ease</span> with<br />which the tests are conducted.</p>
			<div>- Laura R. from Texas</div>
		</div>

		<a name="getting-results"></a>
		<h2 id="h-test-results">Getting Results</h2>

		<div class="col-left">
			<br /><img src="images/sample-results.jpg" width="650" height="530" alt="" border="0" /><br /><br />
		</div>
		<div class="col-right">

			<div class="box_orange_header">
				<div class="header">
					<h3>View My Results</h3>
				</div>
				<div class="content">
					<form action="https://getstdtested.com/customer/account/loginPost" method="post">
						<span style="color: #1e6884; padding-bottom: 6px;">Email:<br /></span> <input class="text" name="login[username]" type="text" value="" /> 
						<span style="color: #1e6884; padding-bottom: 6px;">Password:<br /></span> <input class="text" name="login[password]" type="password" value="" />
						<div class="cboth"></div>
						<input class="submit" type="submit" value="login" />
						<div style="float: right; margin-top: 20px;"><a class="read_more" href="http://getstdtested.com/customer/account/forgotpassword/">forgot password?</a></div>
						<div class="cboth">&nbsp;</div>
					</form>
				</div>
			</div>
			
			<div class="cboth"><br /><br /></div>
			
			<a href="#get-tested" title="Order a Test Today" id="b-order-test-today">Order a Test Today</a>
		
		</div>
		<div class="cboth">&nbsp;</div>
		
		<div class="quote">
			<p>The process was completely thorough, quick,<br />fast, and everything was great. <span>It was everything I was<br />looking for</span> in this type of situation.</p>
			<div>- Mark W. from Ohio</div>
		</div>

		<a name="get-tested"></a>
		<h2 id="h-get-tested-today">Get Tested Today</h2>
		
		<div id="order">
		
				<?php 
               	
               	//if ($labId =  Mage::getSingleton('core/session')->getLabId()){
		
				?>

					<h2 class="first"><strong>To view STD tests available in your area,<br />enter zip code.</strong> Then, select tests.</h2>
					
					<?php		
		
				//} else { 
				?>
				
					<!--<h2 class="first"><strong>To view STD tests available in your area,<br />enter zip code.</strong> Then, select tests.</h2>-->
				
				<?php
				
				//}
				
				?>
					
					<div id="your-zip-code">
						<form onsubmit="return false;" id="location_form">
							<input type="text" onKeyPress="return submitenter(event);" class="text" id="zip_code" name="zip_code" value="Enter Zip Code" onfocus="javascript: if(this.value == 'Enter Zip Code') this.value = '';" onblur="javascript: if(this.value == '') this.value = 'Enter Zip Code';" />
							<input id="location_submit_button" class="submit btn_orange_32_reflection" type="button" onClick="handlerFunction();return false;" value="Submit" />
							<img style="display: none; float: right; margin-right: 47%;" id="ajax-loader-gif" src="/media/images/ajax-loader.gif" />
						</form>
					</div>
					
					<div style="clear:both;"><br /></div> 
					
					


                    <div id="order_module2">
					
                    	<form name="orderWidget" id="orderWidget" method="post" action="http://getstdtested.com/customroute/index/checkout">

                            <div id="at_home">
                                <div class="header">At-Home Testing</div>
                                <div class="content">
                                    <ul>
                                        <li><input type="checkbox" value="105.0000" id="hiv-home" onClick="updateWidgetTotal(this.id,4);toggleCartElement(this.id);" name="homeTest[hiv-home]" /><label for="hiv-home">HIV Standard</label></li>
										<li class="price">$105</li>
                                    	<li><input <?php //if (Mage::getSingleton('core/session')->getIsNnr()) { ?> disabled='disabled'<?php //} ?> type="checkbox" value="165.0000" id="chlamydia-gonorrhea-home" onClick="updateWidgetTotal(this.id,44);toggleCartElement(this.id);" name="homeTest[chlamydia-gonorrhea-home]" /><label for="chlamydia-gonorrhea-home">Chlamydia &amp; Gonorrhea</label></li>
										<li class="price">$165</li>
                                        <li><input <?php //if (Mage::getSingleton('core/session')->getIsNnr()) { ?> disabled='disabled'<?php //} ?> type="checkbox" value="205.0000" id="trichomoniasis-home" onClick="updateWidgetTotal(this.id,3);toggleCartElement(this.id);" name="homeTest[trichomoniasis-home]" /><label for="trichomoniasis-home">Trichomoniasis</label></li>
										<li class="price">$205</li>
                                    </ul>
                                </div>
                            </div>

                            <div id="lab_package">
                                <div class="header">Complete Lab Testing Package</div>
                                <div class="content">
                                    <ul>                                    	
                                        <li>HIV Standard</li>
                                        <li>Chlamydia</li>
                                        <li>Gonorrhea</li>
                                        <li>Oral Herpes</li>
                                        <li>Genital Herpes</li>
                                        <li>Syphilis</li>
                                        <li>Hepatitis B</li>
                                        <li>Hepatitis C</li>
                                    </ul>
									<div style="clear: both;"></div>
                                </div>
								<div id="lab_packapge_footer">
									<span class="price">$229</span>
									<input type="radio" id="expert_package" value="229" onClick="updateWidgetTotal(this.id,14);toggleCartElement(this.id);" name="testPackage" />
									<label for="expert_package">ADD TO CART</label>
									<input id="expert_package_hidden" type="hidden" name="pack_14" value="229">
									<div style="clear: both;"></div>
								</div>
                            </div>

                            <div id="lab_tests1">
                                <div class="header">Lab Testing</div>
                                <div class="content">
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
                                        <li><input type="checkbox" <?php //if (Mage::getSingleton('core/session')->getLabType() == 119) { ?> disabled="disabled" <?php //} ?> value="179.0000" id="hiv-early-detection-lab" onClick="updateWidgetTotal(this.id,13);toggleCartElement(this.id);" name="indiTest[hiv-early-detection-lab]" /><label for="hiv-early-detection-lab">HIV Early Detection *</label></li>
										<li class="price">$179</li>
                                    </ul>
                                </div>
                            </div>

							<div id="your_order">                                    
                                <div class="total">
                                	ORDER TOTAL<br />
                                    <span id="total_price"><div id="widget_total">$0</div></span>
                                </div>
                                <input type="button" onclick="checkEmpty();" class="submit btn_orange_32_reflection" value="continue" style="width: 125px;" />
                            </div>
							
							<input type="hidden" id="package" name="package" value="">  							
							
						</form>
						<div id="expert_package-cart" style="display:none;"></div>
					</div>
					<div class="cboth"><br /></div>
					<p style="padding: 2px 40px 16px 40px;">
						* ABOUT HIV TESTING<br />
						The HIV early detection test is a DNA-based test that can detect the virus as early as two weeks after possible exposure. However, our physician's recommend pairing the early detection test with the HIV Standard test, which is considered the "gold standard" in HIV screening. However, it may take up to 12 weeks for the HIV Standard test to provide accurate results. Repeat HIV testing is recommended for sexually active adults with multiple partners or concern of exposure.
					</p>		
			<div id="trustbuilders2">
				<p>Trusted by customers, the FDA and the sexual community</p>
				<p>Average Customer Review &ndash; <strong>4.5 out of 5 Stars</strong></p>
			</div>
				
		</div>
		<div class="cboth"><br /></div>
	
	</div>
	
	<div id="footer">
		<div class="col-left">
			<h2>About Ourselves</h2>
			<p><span>GetSTDtested.com is America's leading and most trusted online STD testing clinic&nbsp;–&nbsp;providing you peace of mind through confidential, accurate, and convenient&nbsp;STD testing and STD information.</span></p>
		</div>
		<div class="col-right">
			<h2>Get Tested Today</h2>
			<p><a href="#get-tested" id="b-see-testing-options">See Testing Options</a></p>
		</div>
		<div class="col-left">
			<p>&copy; 2012 getSTDtested.com. All rights reserved. &nbsp;|&nbsp; <a href="http://getstdtested.com/terms-of-service">Terms &amp; Conditions</a> &nbsp;|&nbsp; <a href="http://getstdtested.com/privacy-policy">Privacy Policy</a></p>
		</div>
		<div class="col-right">
			<p><span>Call 866-749-6269</span></p>
		</div>
		<div class="cboth">&nbsp;</div>
	</div>

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
	 
	<!-- ClickTale Bottom part -->
	<div id="ClickTaleDiv" style="display: none;"></div>
	<script type='text/javascript'>
	document.write(unescape("%3Cscript%20src='"+
	 (document.location.protocol=='https:'?
	  'https://clicktale.pantherssl.com/':
	  'http://s.clicktale.net/')+
	 "WRc5.js'%20type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
	var ClickTaleSSL=1;
	if(typeof ClickTale=='function') ClickTale(14137,0.0857,"www03");
	</script>
	<!-- ClickTale end of Bottom part -->

</div>


</body>
</html>

