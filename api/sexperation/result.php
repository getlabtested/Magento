<?php include "config.php";
include "facebook.php";
define("FACEBOOK_APP_ID", FBAPP_ID);
define("FACEBOOK_API_KEY", FBAPP_KEY);
define("FACEBOOK_SECRET_KEY", FBAPP_SECRET);
define("FACEBOOK_CANVAS_URL", FBAPP_URL);

include_once 'facebook.php';

$facebook = new Facebook(array(
'appId'  => FACEBOOK_APP_ID,
'secret' => FACEBOOK_SECRET_KEY,
'cookie' => true,
));
 
$session = $facebook->getSession();
 
if (!$session) {
 
$url = $facebook->getLoginUrl(array(
'canvas' => 1,
'fbconnect' => 0
));
 
echo "<script type='text/javascript'>top.location.href = '$url';</script>";
 
} else {
 
try {
 
$uid = $facebook->getUser();
$me = $facebook->api('/me');
  
$uname =  "Hi " . $me['name'] . "!";
 
} catch (FacebookApiException $e) {
 
//do nothing;
}
}
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="keywords" content="<?=$settings['meta_keywords']?>"/>
	<meta name="description" content="<?=$settings['meta_description']?>"/>
	<title><?=$settings['site_name']?></title>
 <script type="text/javascript" src="<?=$settings['fbapp_path']?>jquery.js"></script>
 <script type="text/javascript" src="<?=$settings['fbapp_path']?>SDOScalculator.js"></script>   
<link type="text/css" rel="stylesheet" href="<?=$settings['fbapp_path']?>style.css" />
</head>
<body>
<div id="fb-root"></div>

        <script type="text/javascript">

            window.fbAsyncInit = function() {

                FB.init({appId: '<?=$settings['fbapp_id']?>', status: true, cookie: true, xfbml: true});

                /* All the events registered */

                FB.Event.subscribe('auth.login', function(response) {

                    // do something with response

                    login();

                });

                FB.Event.subscribe('auth.logout', function(response) {

                    // do something with response

                    logout();

                });
            
  FB.Canvas.setAutoResize();

            };

            (function() {

                var e = document.createElement('script');

                e.type = 'text/javascript';

                e.src = document.location.protocol +

                    '//connect.facebook.net/en_US/all.js';

                e.async = true;

                document.getElementById('fb-root').appendChild(e);

            }());
function streampub()
{
FB.ui(
   {
     method: 'feed',
     name: 'Sexperation',
     link: '<?=FBAPPL_PATH?>',
     picture: '<?=$settings['fbapp_path']?>webban.png',
     caption: 'six degrees of sexperation',
     description: 'Sexperation lets you check how many direct and indirect sexual partners you have had in your life in real.',
     message: 'I have had sex with <?=$_GET['hidden_sum']?> people!'
   },
   function(response) {
     if (response && response.post_id) {
       alert('Post was published.');
     } else {
       alert('Post was not published.');
     }
   }
 );
}

</script>
<div class="buttons">
<div class="uname"><?=$uname?></div>
<a href="<?=FBAPPL_PATH?>" target="_blank"><img src="fan.gif" class="btn"/></a>
<a href="invite.php"><img src="invite.gif" class="btn"/></a>
</div>
<div class="container"> 
<img src="logo.png" alt="logo"/>
<div id="middle" class="indirectPartnersCalculator">
					
					<div id="indirectPartnersCalculatorIntro" align="center">
					<br />
					<span id="result"><h3>You had sex with <strong style='color: #db6027;font-size: 36px;'><?=$_GET['hidden_sum']?></strong> people.</h3></span>
					<br />
<a href="javascript:void(0);" onclick="streampub();return false;"><img src="fbshare.png" alt="share it"/></a>
<p style="color: #343434;font-size: 16px;">POWERED BY</p>
<h3>GET<span style="color: #db6027;">STD</span>TESTED.COM</h3>
<br/>
<p style="color: #343434;font-size: 12px;">10% OFF STD TESTING WITH CODE "SEXPERATION"</p>
<a href="http://getstdtested.com/std-testing-options" target="_blank"><img src="learn.png" alt=""/></a>
</div>
<div class="resdiv" align="center">
1 IN 2 SEXUALLY ACTIVE PEOPLE WILL GET AN STD BY THE AGE OF 25.THE GOOD NEWS - ALL STDS ARE TREATABLE AND CURABLE.<br/>
WITH A SIMPLE ROUND OF ANTIBIOTICS.INTERESTED IN LEARNING PRIVATE STD TESTING WITH NO INSURANCE REPORTING?<br/>
<br/>
TAKE CHARGE OF YOUR SEXUAL HEALTH - NO MATTER WHAT THE OCCASION - WITH GETSTDTESTED.COM<br/>
<strong>PHONE:</strong>866-749-6269<br/>
<strong>ONLINE:</strong>WWW.GETSTDTESTED.COM<br/>
<strong>SAVE:</strong>10% OFF TESTING WITH CODE <strong>"SEXPERATION"</strong><br/>

</div>
                </div>
                
 </div>  
</body>
</html>