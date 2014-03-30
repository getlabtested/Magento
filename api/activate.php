<?php
ini_set("memory_limit","-1"); ini_set('auto_detect_line_endings', true);
ini_set("display_errors",1);
date_default_timezone_set('America/Los_Angeles');

$storeId = 2;

require '../app/Mage.php';

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

$tmp = Mage::app()->getRequest()->getParam('x');

if ($tmp) {

$orderId = $tmp/1488;

$order = Mage::getModel('sales/order')->load($orderId);

$order->setPpmdActivate(1);

$order->save();

Mage::getModel('medivo/medivo')->createCustomer($order,1);

Mage::getModel('sendmail/sendmail')->sendEmail($order->getId(),'ppmd_order_confirmation_pwc_active');

}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PPMD Order Activation Confirmation</title>
<meta name="description" content="Default Description" />
<meta name="keywords" content="Magento, Varien, E-commerce" />
<meta name="robots" content="*" />
<link rel="icon" href="http://getstdtested.com/skin/frontend/enterprise/default/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="http://getstdtested.com/skin/frontend/enterprise/default/favicon.ico" type="image/x-icon" />
<!--[if lt IE 7]>
<script type="text/javascript">
//<![CDATA[
    var BLANK_URL = 'http://getstdtested.com/js/blank.html';
    var BLANK_IMG = 'http://getstdtested.com/js/spacer.gif';
//]]>
</script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="http://getstdtested.com/skin/frontend/enterprise/getstdtested/css/template.css" media="all" />
<link rel="stylesheet" type="text/css" href="http://getstdtested.com/skin/frontend/enterprise/getstdtested/css/widget-template.css" media="all" />
<link rel="stylesheet" type="text/css" href="http://getstdtested.com/skin/frontend/enterprise/getstdtested/css/jag.css" media="all" />
<link rel="stylesheet" type="text/css" href="http://getstdtested.com/skin/frontend/enterprise/getstdtested/css/SpryAccordion.css" media="all" />
<link rel="stylesheet" type="text/css" href="http://getstdtested.com/skin/frontend/enterprise/default/aw_blog/css/style.css" media="all" />

<link rel="stylesheet" type="text/css" href="http://getstdtested.com/skin/frontend/base/default/testrecommender/styles.css" media="all" />
<script type="text/javascript" src="http://getstdtested.com/js/prototype/prototype.js"></script>
<script type="text/javascript" src="http://getstdtested.com/js/lib/ccard.js"></script>
<script type="text/javascript" src="http://getstdtested.com/js/prototype/validation.js"></script>
<script type="text/javascript" src="http://getstdtested.com/js/scriptaculous/builder.js"></script>
<script type="text/javascript" src="http://getstdtested.com/js/scriptaculous/effects.js"></script>
<script type="text/javascript" src="http://getstdtested.com/js/scriptaculous/controls.js"></script>
<script type="text/javascript" src="http://getstdtested.com/js/scriptaculous/slider.js"></script>

<script type="text/javascript" src="http://getstdtested.com/js/varien/js.js"></script>
<script type="text/javascript" src="http://getstdtested.com/js/varien/form.js"></script>
<script type="text/javascript" src="http://getstdtested.com/js/varien/menu.js"></script>
<script type="text/javascript" src="http://getstdtested.com/js/mage/cookies.js"></script>


<script type="text/javascript" src="http://getstdtested.com/js/varien/weee.js"></script>
<script type="text/javascript" src="http://getstdtested.com/skin/frontend/enterprise/getstdtested/js/main.js"></script>
<script type="text/javascript" src="http://getstdtested.com/skin/frontend/enterprise/getstdtested/js/SpryAccordion.js"></script>
<script type="text/javascript" src="http://getstdtested.com/skin/frontend/enterprise/default/js/enterprise/catalogevent.js"></script>
<script type="text/javascript" src="http://getstdtested.com/skin/frontend/enterprise/default/js/opcheckout.js"></script>

<!--[if lt IE 7]>
<script type="text/javascript" src="http://getstdtested.com/js/lib/ds-sleight.js"></script>
<![endif]-->

<script type="text/javascript">
//<![CDATA[
Mage.Cookies.path     = '/';
Mage.Cookies.domain   = '.getstdtested.com';
//]]>
</script>

<script type="text/javascript">
//<![CDATA[
optionalZipCountries = [];
//]]>
</script>

<style>
	#error-display { background-image:url(http://c240340.r40.cf1.rackcdn.com/error-popup-background.jpg); background-repeat:no-repeat; width:523px; height:255px; }
	#error-display .content { width:310px; height:255px; float:right; padding:15px; }
	#error-display .content .text { text-align:left; margin-top:50px; }
	#process-order-msg { width:920px; }
	#process-order-msg ol { margin-left:0px; }
	#process-order-msg .arrow-process-order { background-image:url(http://c240340.r40.cf1.rackcdn.com/arrow-process-order.gif); background-repeat:no-repeat; width:259px; height:211px; float:left; margin:20px 20px 20px 0; }
</style>

<script type="text/javascript">var Translator = new Translate({"Please use only letters (a-z or A-Z), numbers (0-9) or underscore(_) in this field, first character should be a letter.":"Please use only letters (a-z or A-Z), numbers (0-9) or underscores (_) in this field, first character must be a letter."});</script></head>
<body class=" checkout-onepage-success"> <!-- 1column layout -->

	<div class="bg_white" id="header_wrapper">    
            



<div id="header" class="all">

            
    <a id="logo" href="http://getstdtested.com/"></a>
    
    <div id="social">	
        <div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#appId=106286916143413&amp;xfbml=1"></script><fb:like href="http://getstdtested.com" send="false" layout="button_count" width="auto" show_faces="false" action="recommend" font=""></fb:like>
        <g:plusone size="small" href="http://getstdtested.com"></g:plusone>
    </div> <!-- /social -->
    
    <div class="phone orange" id="header_phone">866-749-6269</div>
    
    <div id="user_nav">
        <div id="user_nav_search" class="user_nav_box">

            <a class="header" href="" onclick="javascript: openTopSearch();return false;">Search</a>
            <div class="bottom_void">&nbsp;</div>
            <div id="user_nav_search_box" class="user_nav_content_box">
                <form action="http://getstdtested.com/custom-search" method="get">
                	<input type="text" class="text" id="q" name="q" />
                    <input type="submit" class="submit btn_blue_reflection" value="search" />
                </form>
                <div class="clear">&nbsp;</div>

            </div>
        </div> <!-- /search -->
        <div id="user_nav_account" class="user_nav_box">
            <a class="header" href="" onclick="javascript: openTopAccount();return false;">My Results</a>
            <div class="bottom_void">&nbsp;</div>
            <div id="user_nav_account_box" class="user_nav_content_box">
                <form action="" method="post">
                	<p>

                    	<label>E-mail: </label><br />
                        <input type="text" class="text" id="email" name="email" />
                    </p>
                    <p>
                    	<label>Password: </label><br />
                        <input type="password" class="text" id="password" name="password" />
                    </p>
                    <input style="margin-left:0px;" type="submit" class="submit btn_blue_reflection" value="login" />

                </form>
                <div style="float:right; margin-top:10px;"><a class="read_more" href="http://getstdtested.com/customer/account/forgotpassword/">Forgot Password?</a></div>
            </div>
        </div> <!-- /account -->
        <div id="user_nav_cart" class="user_nav_box">
            <a class="header" href="http://getstdtested.com/std-testing-options">Cart</a>
        </div> <!-- /cart -->

    </div> <!-- /user_nav -->
    
    <div class="clear"></div>
    
    <div id="top_menu">
        <div class="content">
            <ul>
                <li><a href="http://getstdtested.com/std-tests">STD Test & Prices</a></li>
                <li><a href="http://getstdtested.com/how-std-testing-works">How It Works</a></li>

                <li><a href="http://getstdtested.com/at-home-std-tests">Home STD Testing</a></li>
                <li>
                	<a href="http://getstdtested.com/locate-testing-center">Test Locally</a>
                	<div class="top_submenu">
                    	<form action="/locate-testing-center" method="post">
                        	<label>Enter Zip Code</label>
                        	<input type="hidden" value="home" name="ref_page">

                            <input type="text" class="text" name="zip_code" />
                            <input type="submit" class="submit btn_orange_32_reflection" value="submit" />
                        </form>
                    </div>
                </li>
                <li><a href="http://getstdtested.com/blog">Blog</a></li>
                <li class="last"><a href="http://getstdtested.com/sample-results">Your Results</a></li>
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


		<div id="process-order-msg">
		    <div class="arrow-process-order"></div>
		    <h2>Your order has been placed successfully.</h2>
		    Many thanks for your business and trust.
		    <h1>Here's what you need to do next:</h1>
		    <ol>
		        <li>Check your e-mail for detailed testing instructions. If you don't see it, please check your SPAM folder.</li> 
		        <li>Print the forms attached to the e-mail.  If you don't have a printer, we'll happily fax them on your behalf.</li>
		        <li>Visit the lab for testing.  No appointment needed.</li>
		    </ol>
		    <b>Questions?</b><br>
		    We're at your service.  Just call us at <b>866.749.6269</b>
		</div>

                
			</div> <!-- /.all -->
        </div> <!-- /.bg_white -->
    
	<div id="footer" class="all">
	   
    <div id="menu_tests" class="border-right column">
        <h4>STD Tests</h4>

        <table>
            <tr>
                <td>
                    <ul>
                        <li><a href="/chlamydia-test">Chlamydia Test </a></li>
                        <li><a href="/gonorrhea-test">Gonorrhea Test </a></li>
                        <li><a href="/hiv-test">HIV Test</a></li>

                        <li><a href="/syphilis-test">Syphllis Test</a></li>
                        <li><a href="/hepatitis-b-test">Hepatitis B Test </a></li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li><a href="/hepatitis-c-test">Hepatitits C Test </a></li>

                        <li><a href="/at-home-std-tests">At-Home Tests </a></li>
                        <li><a href="/oral-herpes-test">Oral Herpes Test </a></li>
                        <li><a href="/genital-herpes-test">Genital Herpes Test </a></li>
                        <li><a href="/trichomoniasis-test">Trichomoniasis Test </a></li>
                    </ul>
                </td>
            </tr>

        </table>
    </div> <!-- /menu_test -->
    <div id="menu_popular" class="border-right column">
        <h4>Popular Content</h4>
        <ul>
            <li><a href="/std-testing-options">STD Tests & Prices</a></li>
            <li><a href="/how-std-testing-works">How STD Testing Works</a></li>

            <li><a href="/locate-testing-center">Find STD Test Location</a></li>
            <li><a href="/symptoms-of-stds">Symptoms of STDs</a></li>
            <li><a href="/sample-results">View STD Test results</a></li>
            <li><a href="/blog">Blog</a></li>
            <li><a href="/forum">Forum</a></li>
        </ul>

    </div> <!-- /menu_popular -->
    <div id="menu_pinpoint" class="border-right column">
        <h4>Meet PinpointMD</h4>
        <ul>
            <li><a href="/meet-ppmd">Meet Us</a></li>
            <li><a href="/medical-advisory-board">Medical Advisory Board</a></li>
            <li><a href="/terms-of-service">Terms</a></li>

            <li><a href="/privacy-policy">Privacy Policy</a></li>
            <li><a href="/site-map">Site Map</a></li>
            <li><a href="/contact-us">Contact</a></li>
        </ul>
    </div> <!-- /menu_popular -->
    <div id="menu_contact" class="column">
        <div class="box_dark">

            <h4>Test for STDs in Complete Privacy</h4>
            <p>Fast, easy, and as accurate as hospital testing.</p>
            <a class="btn_orange" href="/std-testing-options">order now</a>
            <div class="clear"></div>
        </div>
        <h4 class="social">
            Stay in Touch: 
            <!-- <a href="#" target="_blank" class="fb"><img src="http://getstdtested.com/skin/frontend/enterprise/getstdtested/images/icon_fb.png" /></a> -->

            <a href="http://twitter.com/getstdtested" target="_blank" class="twitter"><img src="http://getstdtested.com/skin/frontend/enterprise/getstdtested/images/icon_tweeter.png" /></a>
        </h4>
        <div class="address">
            <div class="left">25 E. Washington St., Ste. 400 </div>
            <div class="right">Chicago, IL 60610</div>
        </div>
    </div> <!-- /menu_contact -->

    <div class="clear"></div>
</div>


	</body>
</html>

