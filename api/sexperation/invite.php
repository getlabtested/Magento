<?PHP
require_once 'config.php';
require_once 'facebook.php';

define("FACEBOOK_APP_ID", FBAPP_ID);
define("FACEBOOK_API_KEY", FBAPP_KEY);
define("FACEBOOK_SECRET_KEY", FBAPP_SECRET);
define("FACEBOOK_CANVAS_URL", FBAPP_URL);

include_once 'facebook.php';

$facebook = new Facebook(array(
'appId'  => FACEBOOK_APP_ID,
'secret' => FACEBOOK_SECRET_KEY,
'cookie' => true,
'domain' => 'omp3.org'
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
 
$updated = date("l, F j, Y", strtotime($me['updated_time']));
 
$uname = $me['name'];

 
} catch (FacebookApiException $e) {
 
echo "Error:" . print_r($e, true);
 
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="keywords" content="<?=$settings['meta_keywords']?>"/>
	<meta name="description" content="<?=$settings['meta_description']?>"/>
	<title><?=$settings['site_name']?></title>
 <script type="text/javascript" src="<?=$settings['fbapp_path']?>jquery.js"></script>
<link type="text/css" rel="stylesheet" href="<?=$settings['fbapp_path']?>style.css" />
</head>
<body>
<div id="fb-root"></div>
<script>
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
<style type="text/css">

.frameBox  iframe{ width: 744px; height: 500px; overflow: hidden;}

</style>
<img src="logo.png" alt=""/>
<div class="framebox">
<fb:serverfbml width="744" height="490"> 
<script type="text/fbml">
<fb:request-form
method="post"
action ="<?=FBAPP_URL?>index.php"
type="<?=FBAPP_NAME?>"
invite="true"
content="Check out the sexperation facebook app from getstdtested.com!<fb:req-choice url='<?=FBAPPL_PATH?>' label='Know your <?=FBAPP_NAME?>' /> ">
<fb:multi-friend-selector actiontext="Tell your friends about <?=FBAPP_NAME?>" rows="3" showborder="false" />
</fb:request-form>
</script>
</fb:serverfbml>
</div>
</body>
</html> 