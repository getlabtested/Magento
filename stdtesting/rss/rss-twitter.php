<?php

	//define('MAGPIE_CACHE_ON', false);
	require_once 'rss_fetch.inc';
	$rss = fetch_rss($url);
	$i = 0;
	//@todo Move the css to a css file

?>

<style type="text/css" media="print, screen">
<!--
	.health-twitter { list-style: none; padding: 0; margin: 0;}
	.tweet {margin: 6px 0px; padding: 3px 5px;}
	.alt0 {background-color: #eee;}
	.alt1 {}
-->
</style>

<div style="padding-left: 15px;">
	<h5>Updates About STDs</h5>
	<ul class="health-twitter">
		<?php if($rss->items) { ?>
			<?php shuffle($rss->items); ?>
			<?php foreach ($rss->items as $item) { ?>
			<?php if ($i < 5) { ?>
			<li class="tweet alt<?php echo ($i & 1); ?>"><?php echo $item['title']; ?></li>
			<?php } ?>
			<?php $i++; ?>
			<?php } ?>
		<?php } else { ?>
			<li><span class="no-tweet">No Tweets Found</span></li>
		<?php } ?>
	</ul>
</div>
