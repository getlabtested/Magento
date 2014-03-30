<?php

	require '../../app/Mage.php';
	require '../../app/code/local/Jag/Orderwidget/Block/Orderwidget.php';
 
	if (!Mage::isInstalled()) {
		echo "Application is not installed yet, please complete install wizard first.";
		exit;
	}

	$_SERVER['SCRIPT_NAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_NAME']);
	$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_FILENAME']);

	Mage::app();
	Mage::app()->setCurrentStore(1);
	
	$orderWidget = new Jag_Orderwidget_Block_Orderwidget;
 
 
 	function getProducts() {

		foreach (Mage::getModel('catalog/product')->getCollection() as $temp) {
		
			$id = $temp->getId();
						
			$product = Mage::getModel('catalog/product')->load($id);
			
			$arr = array();
			$arr['id'] = $id;
			$arr['price'] = $product->getPrice();
		
			$catalog[$product->getSku()] = $arr;
		
		} 
    
    	return $catalog;
    
    }
 
?>

<?php

//echo "<pre>";  print_r(Mage::getModel('core/session')->getData()); echo "</pre>";

if ($quoteId = Mage::getSingleton('core/session')->getQuoteId()) {

	$quote = Mage::getModel('sales/quote')->load($quoteId);
	
	if ($quote->getItemsQty() > 0) {
		
		foreach ($quote->getAllItems() as $item) {
			
			$quote->removeItem($item->getId());
			
		}
	
		$quote->collectTotals()->save();	
	
	}

}



$_products = getProducts();

$state = Mage::getSingleton('core/session')->getOrderState();

$sZip = Mage::getSingleton('core/session')->getZip();

if ($sZip) {

	$sesZip = $sZip;

} else {

	$sesZip = 'Zip Code';

}

//echo "<pre>"; print_r(Mage::getSingleton('core/session')->getData()); echo "</pre>"; 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Get STD Tested</title>

	<link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
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
            'http://getstdtested.com/medivo/local/getlabsorder',
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
		<h1>Get Peace of Mind</h1>
		<h2>100% Confidential Online Test Results</h2>
		<ul>
			<li>View Quick, Accurate Results Online</li>
			<li>Convenient &amp; Simple Testing</li>
			<li>Your Privacy 100% Guaranteed</li>
			<li>Less Than Half the Price of a Doctor's Visit</li>
		</ul>
		<div id="b-get-tested"><a href="#get-tested" title="Get Tested Today">Get Tested Today</a></div>
	</div>
	
	<div id="trustbuilders">
		<p>Trusted by customers, the FDA and the sexual community</p>
		<p>Average Customer Review &ndash; <strong>4.5 out of 5 Stars</strong></p>
	</div>
	
</div>
	
<div class="container-blue-214">
	<div class="wrap">
	
		<div class="quote">
			<p>My doctor wouldn't have been able to see me for 2 months.<br /><span>I was able to get same day testing</span> through your service and<br />my test results came back sooner than 3 days.</p>
			<div>- Male, 36 from Illinois</div>
		</div>
	
	</div>
</div>

<div class="wrap">

	<a name="how"></a>
	<h2><span>How</span> it Works?</h2>
	
	<ul id="how-it-works">
		<li id="how-it-works-1">
			<h3>Choose Your Testing Options:</h3>
			<p>
				Select which STDs to test for and whether you’d prefer to be tested at home or at one of our 4,000 convenient lab locations. We accept credit / debit cards, e-checks and anoymous cash drop-off.<br />
				<a href="#get-tested">See Testing Options</a> &nbsp; | &nbsp; <a href="#get-tested">Find a Testing Location</a>
			</p>
		</li>
		<li id="how-it-works-2">
			<h3>Take The Test:</h3>
			<p>
				Visit our nearest lab - we have over 4,000 locations - or take the test from the comfort of your own home and send the sample in.<br />
				<a href="http://getstdtested.com/test-recommender/test-recommendation.php" id="test-recommender">What Should I Test For?</a> &nbsp; | &nbsp; <a href="#get-tested">Locate Nearest Lab</a>
			</p>
		</li>
		<li id="how-it-works-3">
			<h3>Checking Your Results:</h3>
			<p>
				Your test results will be ready within 1-3 days (faster than a doctor’s office) and you’ll be notified the second they are available. You can then view them via secure online portal or discuss them over the phone.<br />
				<a href="#getting-results">View Sample Test Results</a> &nbsp; | &nbsp; <a href="#get-tested">Get Tested Today</a>
			</p>
		</li>
		<li id="how-it-works-4">
			<h3>Treatment Options:</h3>
			<p>
				If the news isn’t good, you still have options. Discuss your test with our In-house physicians 24/7 to help interpret test results and answer questions. From medication to antibiotics, get private treatment to get on with your life.<br />
				<a href="#get-tested">Get Tested Today</a>
			</p>
		</li>
	</ul>

	<div class="phone-cta">Questions? Call 866-749-6269</div>

</div>
	
<div class="container-blue-214">
	<div class="wrap">
	
		<div class="quote">
			<p>I would recommend you and I will use your services again.<br /><span>I appreciate the convenience, confidentiality, and ease</span> with<br />which the tests are conducted.</p>
			<div>- Laura R. from Texas</div>
		</div>
	
	</div>
</div>

<div class="wrap">

	<a name="getting-results"></a>
	<h2><span>Getting</span> Results</h2>

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
					<span style="color: #e77640; padding-bottom: 4px;">Email:<br /></span> <input class="text" name="login[username]" type="text" value="" /> 
					<span style="color: #e77640; padding-bottom: 4px;">Password:<br /></span> <input class="text" name="login[password]" type="password" value="" />
					<div class="cboth">&nbsp;</div>
					<input class="submit btn_blue_reflection" style="margin-left: 0px; float: left;" type="submit" value="login" />
					<div style="float: right; margin-top: 5px;"><a class="read_more" href="http://getstdtested.com/customer/account/forgotpassword/">Forgot Password?</a></div>
					<div class="cboth">&nbsp;</div>
				</form>
			</div>
		</div>
	
	</div>
	<div class="cboth">&nbsp;</div>

</div>
	
<div class="container-blue-214">
	<div class="wrap">
	
		<div class="quote">
			<p>The process was completely thorough, quick,<br />fast, and everything was great. <span>It was everything I was<br />looking for</span> in this type of situation.</p>
			<div>- Mark W. from Ohio</div>
		</div>
	
	</div>
</div>

<div class="wrap">

	<a name="get-tested"></a>
	<h2><span>Get Tested</span> Today</h2>
	
	<div id="order">
	
		<h2 class="first">1. Tell us where you're located: </h2>

		<form onsubmit="return false;" id="location_form">
			<input type="text" onKeyPress="return submitenter(event);" class="text" id="zip_code" name="zip_code" value="Zip Code" maxlength="5" onfocus="javascript: if(this.value == 'Zip Code') this.value = '';" onblur="javascript: if(this.value == '') this.value = 'Zip Code';" />
			<input id="location_submit_button" class="b-submit" type="button" onClick="handlerFunction();return false;" value="Submit" />
			<img style="display:none;float:right;margin-right: 47%;" id="ajax-loader-gif" src="http://getstdtested.com/media/images/ajax-loader.gif" />
		</form>
		<div class="cboth"><br /></div>
		
		<div id="location_results">
		
		<?php if ($state && in_array($state,array('NY','NJ','RI')) && $labId =  Mage::getSingleton('core/session')->getLabId()) { ?> 
			
			<?php 
				foreach (Mage::getSingleton('core/session')->getLabsByZip() as $labOpt) {
					
					$labOpt = (array)$labOpt;
					
					if (isset($labOpt['id'])) $tlab = $labOpt['id'];
					if (isset($labOpt['nnr_id'])) $tlab = $labOpt['nnr_id'];
					
					if ($tlab == $labId && $labOpt['lab-id'] == 129) {	
		
				?>
				<a style="color:#028AFB; font-weight:bold;" href="http://getstdtested.com/locate-testing-center">Update Location</a>
				<p><strong><?php echo $labOpt['name'];?> <?php echo $labOpt['address'];?><br>Due to state regulations in <?php echo Mage::helper('medivo')->getNnrStatesString() ?>, pricing and test options vary by state.  Pricing will be verified after selecting products and clicking checkout. To continue, select STD tests below.</strong></p>
				
				<?php 
				
					break;
				
				} else if  ($tlab == $labId && $labOpt['lab-id'] == 119) { ?>
				<a style="color:#028AFB; font-weight:bold;" href="http://getstdtested.com/locate-testing-center">Update Location</a>
				<p><strong><?php echo $labOpt['name'];?> <br>Due to state regulations in <?php echo Mage::helper('medivo')->getNnrStatesString() ?>, pricing and test options vary by state.  Pricing will be verified after selecting products and clicking checkout. To continue, select STD tests below.</strong></p>
				
				<?php		
				
					}
					
				}
			
				?>
					
		<?php } else if ($state && !in_array($state,array('NY','NJ','RI')) &&  $labId =  Mage::getSingleton('core/session')->getLabId()){
			
				foreach (Mage::getSingleton('core/session')->getLabsByZip() as $labOpt) {
					
					if (isset($labOpt['id'])) $tlab = $labOpt['id'];
					if (isset($labOpt['nnr_id'])) $tlab = $labOpt['id'];
					
					if ($tlab == $labId && $labOpt['lab-id'] == 129) {	
		
		?>
				<a style="color:#028AFB; font-weight:bold;" href="http://getstdtested.com/locate-testing-center">Update Location</a>
				<p><strong><?php echo $labOpt['name'];?> <br> Select your STD tests below and verify or update this location during checkout.</strong></p>
				
		
		<?php		} else if  ($tlab == $labId && $labOpt['lab-id'] == 119) { ?>
				<a style="color:#028AFB; font-weight:bold;" href="http://getstdtested.com/locate-testing-center">Update Location</a>
				<p><strong><?php echo $labOpt['name'];?> <br> Select your STD tests below and verify or update this location during checkout.</strong></p>

				
		<?php		}
					
				}
		
		} else if ($state && !in_array($state,array('NY','NJ','RI')) && !Mage::getSingleton('core/session')->getLabId()) { ?>
		
			<a style="color:#028AFB; font-weight:bold;" href="http://getstdtested.com/locate-testing-center">Update Location</a>
			<p><strong>We have 6+ testing locations near you. Select your preferred location during checkout.</strong></p>
		
		<?php }  else if ($state && in_array($state,array('NY','NJ','RI')) && !Mage::getSingleton('core/session')->getLabId()) { ?>

			<a style="color:#028AFB; font-weight:bold;" href="http://getstdtested.com/locate-testing-center">Update Location</a>
			<p><strong>We have 6+ testing locations near you. However, pricing varies due to state regulations in <?php echo Mage::helper('medivo')->getNnrStatesString() ?>. Proceed to checkout to identify your preferred location and view local pricing.</strong></p>

		<?php } else { ?>
			
			<p><strong>For test availability and local pricing, please enter your zip code.</strong></p>
			
		<?php } ?>
		
		</div>
		<div class="cboth"></div>
		
		<h2 class="first">2. Select STD tests:</h2>

		<div id="order_module"> 
			<form name="orderWidget" id="orderWidget" method="post" action="http://getstdtested.com/customroute/index/checkout">

				<div id="at_home">
					<div class="header">At-Home Testing</div>
					<div class="content">
						<h4><strong>Free</strong> Priority Shipping</h4>
						<ul>
							<li><input  type="checkbox" value="105.0000" onClick="updateWidgetTotal(this.id,1);toggleCartElement(this.id);" id="chlamydia-home" name="homeTest[chlamydia-home]" />Chlamydia</li>
							<li><input  type="checkbox" value="105.0000" id="gonorrhea-home" onClick="updateWidgetTotal(this.id,2);toggleCartElement(this.id);" name="homeTest[gonorrhea-home]" />Gonorrhea</li>
							<li><input  type="checkbox" value="205.0000" onClick="updateWidgetTotal(this.id,3);toggleCartElement(this.id);" id="trichomoniasis-home" name="homeTest[trichomoniasis-home]" />Trichomoniasis</li>
							<li><input type="checkbox" value="105.0000" id="hiv-home" onClick="updateWidgetTotal(this.id,4);toggleCartElement(this.id);" name="homeTest[hiv-home]" />HIV Express<span class="small">(next day results)</span></li>
						</ul>
					</div>
					<div class="footer">
						<span class="price">$105 each</span>
						<span class="info">discounts for multiple tests</span>
					</div>
				</div> <!-- /at_home -->
				
				<div class="sep">OR</div>
				
				<div id="lab_tests">
				
					<div class="header">Local Lab Testing</div>
					
					<div class="item" id="individual_tests">
						<div class="content">
							<h4>Individual Tests</h4>
							<ul>
								<li><input type="checkbox" value="90.0000" id="chlamydia-lab" onClick="updateWidgetTotal(this.id,5);toggleCartElement(this.id);" name="indiTest[chlamydia-lab]" />Chlamydia</li>
								<li><input type="checkbox" value="90.0000" id="gonorrhea-lab" onClick="updateWidgetTotal(this.id,6);toggleCartElement(this.id);" name="indiTest[gonorrhea-lab]" />Gonorrhea</li>
								<li><input type="checkbox" value="90.0000" id="hepatitis-b-lab" onClick="updateWidgetTotal(this.id,7);toggleCartElement(this.id);" name="indiTest[hepatitis-b-lab]" />Hepatitis B</li>
								<li><input type="checkbox" value="90.0000" id="hepatitis-c-lab" onClick="updateWidgetTotal(this.id,8);toggleCartElement(this.id);" name="indiTest[hepatitis-c-lab]" />Hepatitis C</li>
								<li><input type="checkbox" value="90.0000" id="oralherpes-lab" onClick="updateWidgetTotal(this.id,9);toggleCartElement(this.id);" name="indiTest[oralherpes-lab]" />Oral Herpes</li>
								<li><input type="checkbox" value="90.0000" id="genitalherpes-lab" onClick="updateWidgetTotal(this.id,10);toggleCartElement(this.id);" name="indiTest[genitalherpes-lab]" />Genital Herpes</li>
								<li><input type="checkbox" value="90.0000" id="hiv-lab" onClick="updateWidgetTotal(this.id,11);toggleCartElement(this.id);" name="indiTest[hiv-lab]" />HIV</li>
								<li><input type="checkbox" value="90.0000" id="syphilis-lab" onClick="updateWidgetTotal(this.id,12);toggleCartElement(this.id);" name="indiTest[syphilis-lab]" />Syphilis</li>
							</ul>
						</div>
						<div class="footer">
							<span class="price">$90 each</span>
							<span class="info">discounts for multiple tests</span>
						</div>
					</div> <!-- /individual_tests -->
					
					<div class="item" id="basic_package">
						<div class="content">
							<h4>Basic Package</h4>
							<ul>
								<li>Chlamydia</li>
								<li>Gonorrhea</li>
								<li>Genital Herpes</li>
								<li>HIV</li>
							</ul>
						</div>
						<div class="footer">
							<div class="price">$195</div>
							<div class="add_to_cart">
								<input type="radio" id="complete_package" value="195" onClick="updateWidgetTotal(this.id,15);toggleCartElement(this.id);" name="testPackage" /> Add to cart
								<input id="complete_package_hidden" type="hidden" value="195" name="pack_15">
							</div>
						</div>
					</div> <!-- /basic_package -->
					
					<div class="item" id="ultimate_package">
						<div class="content">
							<h4><strong>Best Value Pack</strong></h4>
							<ul>
								<li>Chlamydia</li>
								<li>Gonorrhea</li>
								<li>Hepatitis B</li>
								<li>Hepatitis C</li>
								<li>Oral Herpes</li>
								<li>Genital Herpes</li>
								<li>HIV</li>
								<li>Syphilis</li>
							</ul>
							<div class="add_to_cart">
								<input type="radio" id="expert_package" value="245" onClick="updateWidgetTotal(this.id,14);toggleCartElement(this.id);" name="testPackage" /> Add to cart
								<input id="expert_package_hidden" type="hidden" name="pack_14" value="245">
							</div>
						</div>
						<div class="footer">
							<div class="price">$245 for 8 Tests</div>
						</div>
					</div> <!-- /ultimate_package -->
					
				</div> <!-- /lab_tests -->
				
				<div class="sep sep_arrow">&nbsp;</div>
				
				<div id="your_order">
					<div class="header">Order Details</div>
					<div class="content">
						<div id="ow_list">
						
							<div style="display:none;" id="chlamydia-home-cart">&bull;&nbsp;Chlamydia</div>
							<div style="display:none;" id="gonorrhea-home-cart">&bull;&nbsp;Gonorrhea</div>
							<div style="display:none;" id="trichomoniasis-home-cart">&bull;&nbsp;Trichomoniasis</div>
							<div style="display:none;" id="hiv-home-cart">&bull;&nbsp;HIV Express</div>                 
							<div style="display:none;" id="chlamydia-lab-cart">&bull;&nbsp;Chlamydia</div>
							<div style="display:none;" id="gonorrhea-lab-cart">&bull;&nbsp;Gonorrhea</div>
							<div style="display:none;" id="hepatitis-b-lab-cart">&bull;&nbsp;Hepatitis B</div>
							<div style="display:none;" id="hepatitis-c-lab-cart">&bull;&nbsp;Hepatitis C</div>
							<div style="display:none;" id="oralherpes-lab-cart">&bull;&nbsp;Oral Herpes</div>
							<div style="display:none;" id="genitalherpes-lab-cart">&bull;&nbsp;Genital Herpes</div>
							<div style="display:none;" id="hiv-lab-cart">&bull;&nbsp;HIV</div>
							<div style="display:none;" id="syphilis-lab-cart">&bull;&nbsp;Syphilis</div>

							<div id="complete_package-cart" style="display:none;">
								<div id="chlamydia-lab-cart-cp">&bull;&nbsp;Chlamydia</div>
								<div id="gonorrhea-lab-cart-cp">&bull;&nbsp;Gonorrhea</div>
								<div id="genitalherpes-lab-cart-cp">&bull;&nbsp;Genital Herpes</div>
								<div id="hiv-lab-cart-cp">&bull;&nbsp;HIV</div>
							</div>

							<div id="expert_package-cart" style="display:none;">
								<div id="chlamydia-lab-cart-ep">&bull;&nbsp;Chlamydia</div>
								<div id="gonorrhea-lab-cart-ep">&bull;&nbsp;Gonorrhea</div>
								<div id="hepatitis-b-lab-cart-ep">&bull;&nbsp;Hepatitis B</div>
								<div id="hepatitis-c-lab-cart-ep">&bull;&nbsp;Hepatitis C</div>
								<div id="oralherpes-lab-cart-ep">&bull;&nbsp;Oral Herpes</div>
								<div id="genitalherpes-lab-cart-ep">&bull;&nbsp;Genital Herpes</div>
								<div id="hiv-lab-cart-ep">&bull;&nbsp;HIV</div>
								<div id="syphilis-lab-cart-ep">&bull;&nbsp;Syphilis</div>
							</div>

						</div>

					</div>
						
					<div class="total">
						Total <span id="total_price"><div id="widget_total">$0</div></span>
					</div>
					<input type="button" onclick="checkEmpty();" class="submit btn_orange_32_reflection" value="checkout" style="width: 125px;" />
				</div> <!-- /your_order -->
				<input type="hidden" id="package" name="package" value="">          
			</form>
		</div> <!-- /order_module -->
	
		<div id="trustbuilders2">
			<p>Trusted by customers, the FDA and the sexual community</p>
			<p>Average Customer Review &ndash; <strong>4.5 out of 5 Stars</strong></p>
		</div>
			
	</div>
	<div class="cboth"><br /></div>

</div>
	
<div class="container-blue-139">
	<div class="wrap">

		<div class="phone-cta">Questions? Call 866-749-6269</div>
	
	</div>
</div>

<div class="wrap">
	
	<br />
	<div class="quote">
		<p>I would recommend you guys because overall,<br />the service was perfect and you’re all very professional.<br /><span>I like your company.</span></p>
		<div>- Christopher Q. from Florida</div>
	</div>

</div>
 
<div class="container-blue">
	<div class="wrap">
	
		<div id="footer">
			<div class="col-left">
				<h2>About Ourselves:</h2>
				<p><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce lobortis nibh at sapien scelerisque eget suscipit lorem condimentum. Cras scelerisque suscipit odio ut blandit sodales nisi.</span></p>
			</div>
			<div class="col-right">
				<h2>Get Tested Today:</h2>
				<p><a href="#get-tested" id="b-see-testing-options">See Testing Options</a></p>
			</div>
			<div class="col-left">
				<p>&copy; Copyright 2012 - getSTDtested.com &nbsp;|&nbsp; <a href="http://getstdtested.com/site-map">Sitemap</a> &nbsp;|&nbsp; <a href="http://getstdtested.com/terms-of-service">Terms &amp; Conditions</a> &nbsp;|&nbsp; <a href="http://getstdtested.com/privacy-policy">Privacy Policy</a></p>
			</div>
			<div class="col-right">
				<p><span>Call 866-749-6269</span></p>
			</div>
		</div>
		<div class="cboth">&nbsp;</div>

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
</div>


</body>
</html>

