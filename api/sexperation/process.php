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
<img src="logo.png" alt=""/>
 <h3 style="color: #31838a;">What is Your Gender?</h3>

            
                    <div class="formRow clearfix">

                        <div class="formRowLeftCell">

                           <div class="formRowRadioListContainer">

                                <input name="gender" type="radio" id="gm" value="m" checked="checked" onclick="changeYourGender('male');" /><label

                                    for="gm">Male</label><br />

                                <input name="gender" type="radio" id="gf" value="f" onclick="changeYourGender('female');" /><label

                                    for="gf">Female</label>

                            </div>

                            <!-- /.formRowRadioListContainer -->

                        </div>

                        <!-- /.formRowLeftCell -->

                        <div class="formRowRightCell">
<h3 style="color: #31838a;">How old are you?</h3>
                            <label for="age">

                               </label>

                            <select id="age" style="width: 120px;height: 30px;">

                                <option value="16">16</option>

                                <option value="17">17</option>

                                <option value="18">18</option>

                                <option value="19">19</option>

                                <option value="20">20</option>

                                <option value="21">21</option>

                                <option value="22">22</option>

                                <option value="23">23</option>

                                <option value="24">24</option>

                                <option value="25">25</option>

                                <option value="26">26</option>

                                <option value="27">27</option>

                                <option value="28">28</option>

                                <option value="29">29</option>

                                <option value="30">30</option>

                                <option value="31">31</option>

                                <option value="32">32</option>

                                <option value="33">33</option>

                                <option value="34">34</option>

                                <option value="35">35</option>

                                <option value="36">36</option>

                                <option value="37">37</option>

                                <option value="38">38</option>

                                <option value="39">39</option>

                                <option value="40">40</option>

                                <option value="41">41</option>

                                <option value="42">42</option>

                                <option value="43">43</option>

                                <option value="44">44</option>

                                <option value="45">45</option>

                                <option value="46">46</option>

                                <option value="47">47</option>

                                <option value="48">48</option>

                                <option value="49">49</option>

                                <option value="50">50</option>

                                <option value="51">51</option>

                                <option value="52">52</option>

                                <option value="53">53</option>

                                <option value="54">54</option>

                                <option value="55">55</option>

                                <option value="56">56</option>

                                <option value="57">57</option>

                                <option value="58">58</option>

                                <option value="59">59</option>

                                <option value="60">60</option>

                                <option value="61">61</option>

                                <option value="62">62</option>

                                <option value="63">63</option>

                                <option value="64">64</option>

                                <option value="65">65</option>

                                <option value="66">66</option>

                                <option value="67">67</option>

                                <option value="68">68</option>

                                <option value="69">69</option>

                                <option value="70">70</option>

                                <option value="71">71</option>

                                <option value="72">72</option>

                                <option value="73">73</option>

                                <option value="74">74</option>

                                <option value="75">75</option>

                                <option value="76">76</option>

                                <option value="77">77</option>

                                <option value="78">78</option>

                                <option value="79">79</option>

                                <option value="80">80</option>

                                <option value="81">81</option>

                                <option value="82">82</option>

                                <option value="83">83</option>

                                <option value="84">84</option>

                                <option value="85">85</option>

                                <option value="86">86</option>

                                <option value="87">87</option>

                                <option value="88">88</option>

                                <option value="89">89</option>

                                <option value="90">90</option>

                                <option value="91">91</option>

                                <option value="92">92</option>

                                <option value="93">93</option>

                                <option value="94">94</option>

                                <option value="95">95</option>

                                <option value="96">96</option>

                                <option value="97">97</option>

                                <option value="98">98</option>

                                <option value="99">99</option>

                                <option value="100">100</option>

                                <option value="101">101</option>

                                <option value="102">102</option>

                                <option value="103">103</option>

                                <option value="104">104</option>

                                <option value="105">105</option>

                                <option value="106">106</option>

                                <option value="107">107</option>

                                <option value="108">108</option>

                                <option value="109">109</option>

                                <option value="110">110</option>

                                <option value="111">111</option>

                                <option value="112">112</option>

                                <option value="113">113</option>

                                <option value="114">114</option>

                                <option value="115">115</option>

                                <option value="116">116</option>

                                <option value="117">117</option>

                                <option value="118">118</option>

                                <option value="119">119</option>

                                <option value="120">120</option>

                            </select>

                        </div>

                        <!-- /.formRowRightCell -->

                    </div>

                    <!-- /.formRow -->

                </div>
	<!-- /#indirectPartnersCalculatorIntro -->
<p>&nbsp;</p>
                <table cellspacing="0" class="partnersTable">

                    <tr>

                        <td>

                            <h3 style="color: #31838a;">How many Total sexual partners have you had to date?</h3>
                        

                            <select id="noOfPartners" name="noOfPartners" onchange="return askGender(null); return false;" style="width: 120px;height: 30px;">

                                <option value="0">0</option>

                                <option value="1">1</option>

                                <option value="2">2</option>

                                <option value="3">3</option>

                                <option value="4">4</option>

                                <option value="5">5</option>

                                <option value="6">6</option>

                                <option value="7">7</option>

                                <option value="8">8</option>

                                <option value="9">9</option>

                                <option value="10">10</option>

                                <option value="11">11</option>

                                <option value="12">12</option>

                                <option value="13">13</option>

                                <option value="14">14</option>

                                <option value="15">15</option>

                                <option value="16">16</option>

                                <option value="17">17</option>

                                <option value="18">18</option>

                                <option value="19">19</option>

                                <option value="20">20</option>

                                <option value="21">21</option>

                                <option value="22">22</option>

                                <option value="23">23</option>

                                <option value="24">24</option>

                                <option value="25">25</option>

                                <option value="26">26</option>

                                <option value="27">27</option>

                                <option value="28">28</option>

                                <option value="29">29</option>

                                <option value="30">30</option>

                                <option value="31">31</option>

                                <option value="32">32</option>

                                <option value="33">33</option>

                                <option value="34">34</option>

                                <option value="35">35</option>

                                <option value="36">36</option>

                                <option value="37">37</option>

                                <option value="38">38</option>

                                <option value="39">39</option>

                                <option value="40">40</option>

                                <option value="41">41</option>

                                <option value="42">42</option>

                                <option value="43">43</option>

                                <option value="44">44</option>

                                <option value="45">45</option>

                                <option value="46">46</option>

                                <option value="47">47</option>

                                <option value="48">48</option>

                                <option value="49">49</option>

                                <option value="50">50</option>

                                <option value="Over 50">Over 50</option>

                            </select>

                        </td>

                    </tr>

                </table>
<br/>
                <table cellspacing="0" class="partnersTable">

                    <tbody id="table">

                    </tbody>

                </table>
	 <form name="form1" method="get" action="result.php" id="form1">
                <div style="text-align: right;">
<a href="javascript:void(0);" onclick="javascript:calc();document.form1.submit();return false;"><img src="next.png" style="float: left;width: 120px;margin-top: 2px;" name="bntIndirectPartners" id="bntIndirectPartners" AlternateTex="Calculate my Sex Degrees of Separation total" /></a>
<img src="powered.png" style="float: left;width: 130px;margin-left: 20px;" alt=""/>
                    <input type="hidden" name="hidden_age" id="hidden_age" value="0" />
                    <input type="hidden" name="hidden_direct" id="hidden_direct" value="0" />
                    <input type="hidden" name="hidden_indirect" id="hidden_indirect" value="0" />
                    <input type="hidden" name="hidden_sum" id="hidden_sum" value="0" />
                    <input type="hidden" name="hidden_sumThreeDegrees" id="hidden_sumThreeDegrees" value="0" />
                    <input type="hidden" name="hidden_gender" id="hidden_gender" />
                    <input type="hidden" name="hidden_notchecked" id="hidden_notchecked" />
                </div>

                <div id="summary">
                    <div style="text-align: right">
                    </div>
                </div>
                <div id="summaryBottom">
                </div>
                <p class="topPadding">
                </p>
                	     
</form>    
 </div>  
</body>
</html>