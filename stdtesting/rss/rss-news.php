<?php
	//define('MAGPIE_CACHE_ON', false);
	require_once 'rss_fetch.inc';
	$rss = fetch_rss($url);
	$i = 0;
	//@todo Move the css to a css file
?>

<style type="text/css" media="print, screen">
<!--
	.health-news { list-style: none; padding: 0; margin: 0;}
	.news {margin: 6px 0px; padding: 3px 5px;}
	.alt0 {background-color: #eee;}
	.alt1 {}
-->
</style>

<div>
	<h5>Sexual Health in the News</h5>
	<ul class="health-news">
		<?php if (isset($rss->items)) { ?>
			<?php shuffle($rss->items); ?>
			<?php foreach ($rss->items as $item) { ?>
			<?php if ($i < 5) { ?>
			<li class="news alt<?php echo ($i & 1); ?>"><?php echo $item['title']; ?></li>
			<?php } ?>
			<?php $i++;?>
			<?php } ?>
		<?php } else { ?>
			<li><span class="no-news">No News Found</span></li>
		<?php } ?>
		<li class="news">&raquo; <a href="<?php echo $urlRead; ?>" target="_blank">See more articles</a></li>
	</ul>
</div>
