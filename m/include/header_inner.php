<?php include_once("config.php"); ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<meta http-equiv="cache-control" content="max-age=200" />
<link href="<?php echo ROOT_WWW?>css/style.css" media="handheld, screen" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo ROOT_WWW?>js/jquery-1.4.2.js"></script>
<title><?php echo get_title(basename($_SERVER['REQUEST_URI'], ".php"));?></title>
</head>
<body>
<div class="mainwrapper">
	<div id="header">
		<div class="right-bg">
			<div id="logo"><a href="<?php echo ROOT_WWW?>"><img alt="logo" src="<?php echo ROOT_WWW?>images/logo2.jpg"/></a>			</div>
			<div id="slogan" class="spacer-tp">
				<div class="backtohome">
					<a href="<?php echo ROOT_WWW?>"><img src="<?php echo ROOT_WWW?>images/home-back.jpg" alt="" /></a>				
				</div>
				<div class="title-rt" style="top:-28px;"><?php echo get_title(basename($_SERVER['REQUEST_URI'], ".php"));?></div>
			</div>
		</div>
	</div>