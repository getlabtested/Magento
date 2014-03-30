<?php include_once("include/header.php"); ?>

<!-- Google Website Optimizer Control Script -->
<script>
function utmx_section(){}function utmx(){}
(function(){var k='0853531173',d=document,l=d.location,c=d.cookie;function f(n){
if(c){var i=c.indexOf(n+'=');if(i>-1){var j=c.indexOf(';',i);return escape(c.substring(i+n.
length+1,j<0?c.length:j))}}}var x=f('__utmx'),xx=f('__utmxx'),h=l.hash;
d.write('<sc'+'ript src="'+
'http'+(l.protocol=='https:'?'s://ssl':'://www')+'.google-analytics.com'
+'/siteopt.js?v=1&utmxkey='+k+'&utmx='+(x?x:'')+'&utmxx='+(xx?xx:'')+'&utmxtime='
+new Date().valueOf()+(h?'&utmxhash='+escape(h.substr(1)):'')+
'" type="text/javascript" charset="utf-8"></sc'+'ript>')})();
</script><script>utmx("url",'A/B');</script>
<!-- End of Google Website Optimizer Control Script -->
<!-- Google Website Optimizer Tracking Script -->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['gwo._setAccount', 'UA-10462432-2']);
  _gaq.push(['gwo._trackPageview', '/0853531173/test']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<!-- End of Google Website Optimizer Tracking Script -->

	<div id="content">
		
		<p class="acenter">With over <strong>4,000 local STD testing centers</strong>, select at-home testing kits, and the ability to purchase your STD tests and receive results right from your handheld device, getSTDtested.com is America’s most convenient and trusted online STD testing resource.</p>
		
		<div id="tabs">
			<ul>
				<li><a href="<?php echo ROOT_WWW; ?>how-our-service-works"><span>How Our Service Works</span></a></li>
				<li><a href="<?php echo ROOT_WWW; ?>std-tests-and-pricing"><span>STD Tests &amp; Pricing</span></a></li>
				<li><a href="<?php echo ROOT_WWW; ?>who-should-get-tested"><span>Who Should Get Tested</span></a></li>
			</ul>
		</div>

<?php include_once("include/footer.php"); ?>