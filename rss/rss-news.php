<?php
	define('MAGPIE_CACHE_ON', false);
	require_once 'rss_fetch.inc';
	$rss = fetch_rss($url);
	$rss2 = fetch_rss($url2);
	$i = 0;
	//@todo Move the css to a css file
?>

<style type="text/css" media="print, screen">
<!--
	.health-news { list-style: none; padding: 0; margin: 0;}
	.news {margin: 6px 0px; padding: 3px;}
	.alt0 {}
	.alt1 {background-color:#ECECEC;}
-->
</style>

<div>
	<h3>Sexual Health in the News</h3>
	<ul class="health-news">
		<?php if($rss->items) { ?>
			<?php shuffle($rss->items); ?>
			<?php foreach ($rss->items as $item) { ?>
			<?php if ($i < 5) { ?>
			<li class="news alt<?=($i & 1)?>"><?=$item['title']?></li>
			<?php } ?>
			<?php $i++;?>
			<?php } ?>
		<?php } elseif ($rss2->items) { ?>
			<?php shuffle($rss2->items); ?>
			<?php foreach ($rss2->items as $item) { ?>
			<?php if ($i < 5) { ?>
			<li class="news alt<?=($i & 1)?>"><?=$item['title']?></li>
			<?php } ?>
			<?php $i++;?>
			<?php } ?>
		<?php } else { ?>
			<li><span class="no-news">No News Found</span></li>
		<?php } ?>
	</ul>
</div>
