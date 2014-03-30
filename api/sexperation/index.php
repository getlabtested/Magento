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
$uname =  "Hi!";
 
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
$search = 'featured'; //shows featured music content from youtube music
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
</script>
<div class="buttons">
<div class="uname"><?=$uname?></div>
<a href="<?=FBAPPL_PATH?>" target="_blank"><img src="fan.gif" class="btn"/></a>
<a href="invite.php"><img src="invite.gif" class="btn"/></a>
</div>
<div class="container"> 
<img src="biglogo.png" alt="main logo"/>
<div align="center" style="font-size: 12px;color: #343434;">
<br/>
<p style="color:#242424;font-size: 12px;"><span style="color: #000;font-weight: bold;font-size: 16px;">SEXPERATION&nbsp;</span>(a.k.a the human spider web) refers to an idea that everyone is on average six persons away from having sex with any other person in Earth. Have you had sex with hot receptionist? Maybe. What about the girl next door? Perhaps.<br/><br/>
Take the Sexperation Quiz, built on the logic of six degrees of seperation, to find out how many people you really had sex with.</p>
<br/>
<a href="process.php"><img src="start.png" alt="start"/></a>
<p>POWERED BY</p>
<br/>
<h2 style="color: #000;">GET<span style="color: #d5785a;">STD</span>TESTED.COM</h2>
</div>
 </div>  
</body>
</html>