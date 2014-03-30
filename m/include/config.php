<?php

//##############################################################################//
//                    DATABASE CONFIGURATIONS                                   //
//##############################################################################//
if($_SERVER['HTTP_HOST'] == '192.168.0.55')
{
	define("DB_PLATFORM","dtcmd_01");   // DATABASE NAME
	define("DB_SERVER","localhost"); // SERVER NAME OR HOST NAME
	define("DB_USER","getstdtested"); // USER NAME
	define("DB_PASSWORD","dtcmdSTD97"); // PASSWORD
	define("DB_PCONNECT",true);
	define("BASEPATH",'http://getstdtested.com/m/');
}
else
{
	define("DB_PLATFORM","iflair_getStd");
	define("DB_SERVER","localhost");
	define("DB_USER","root");
	define("DB_PASSWORD","");
	define("DB_PCONNECT",true);
	define("BASEPATH",'http://localsites.pinpointmd.com/m/');
}
//##############################################################################//
//                    BASIC CONFIGURATIONS                                      //
//##############################################################################//
define("SITE_NAME","GetSTDTested");
define("SITE_TITLE","GetSTDTested");
define("ROOT_DIR",$_SERVER["DOCUMENT_ROOT"] . "/m/");
//define("ROOT_WWW","http://".$_SERVER['HTTP_HOST']."/m/");



define("ROOT_WWW","http://getstdtested.com/m/");



define("MIDD_FOLD", ROOT_DIR."middle/");
define("DATETIME", date('Y-m-d h:i:s A'));
define("BLOG",ROOT_WWW."blog");
define("IMAGE",ROOT_WWW."images/");

//##############################################################################//
//                    SITE ADMIN CONFIGURATIONS                                 //
//##############################################################################//
define("ADM_NAME","admin/");		//folder name of admin
define("ADM_FOLDER",ROOT_DIR .ADM_NAME. "");
define("ADM_FOLDER_WWW",ROOT_WWW.ADM_NAME . "");
define("ADM_LEFTPANEL_WWW",ROOT_WWW.ADM_NAME . "boxes/");
define("ADM_CSS", ROOT_WWW .ADM_NAME.  "css/");
define("ADM_JS", ROOT_WWW .ADM_NAME.  "js/");
define("ADM_IMAGES_FOLD", ROOT_WWW .ADM_NAME.  "images/");
define("ADM_MIDD_FOLD", "middle/");
define("HTML_PAGES", ROOT_DIR."allhtml/");
define("HTML_PAGES_WWW", ROOT_WWW."allhtml/");
define("ADM_BOXES_FOLD", "middle/boxes/");
define("ADM_EMAILID","support@getlabtested.net");
define("IMAGE_FILES","images/");
define("FCK_PATH","images/");
//define("SITE_EMAIL","help@dtcmd.com");
define("SITE_EMAIL","dipak.mewada@iflair.com");

/* EMAIL ADDDRESSS
Please also change Email address for wordpress(2 places in admin side) / blog / live chat (db (livehelp_departments ,  livehelp_config) and set admin email address from admin side)
*/ 

define("PACKAGE_VIDEO_UPLOAD_DIR",ROOT_DIR.'upload/package_video');
define("PACKAGE_VIDEO_UPLOAD_DIR_URL",ROOT_WWW.'upload/package_video');
define("TESTIMONIAL_VIDEO_UPLOAD_DIR",ROOT_DIR.'upload/testimonial_video');
define("TESTIMONIAL_VIDEO_UPLOAD_DIR_URL",ROOT_WWW.'upload/testimonial_video');
define("TESTIMONIAL_IMAGES_UPLOAD_DIR",ROOT_DIR.'upload/testimonial_images');
define("TESTIMONIAL_IMAGES_UPLOAD_DIR_URL",ROOT_WWW.'upload/testimonial_images');
define("SIGN",'<span style="color:#FF0000; font-size:15px; padding-right:3px;">*</span>');

//This array declare for Individual package price.
$Price = array(150,195,225,245);
global $Price;

@session_start();

$urlpath=ADM_FOLDER_WWW;
//file path
$path=ADM_FOLDER;

$urlpath2=ROOT_WWW;
//file path
$path2=ROOT_DIR;

include_once("function.php");
?>