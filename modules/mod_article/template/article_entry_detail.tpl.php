<article class='mod_article_entry'>
	<div class='mod_article_info'>
		<h2><?=$tpl_title?></h2>
		Autor: <?=$tpl_author?><br>
		Zuletzt geändert: <?=$tpl_time_last_changed?><br>
		Hits: <?=$tpl_hits?><br>
	</div>
	<section class='article_content'>
		<?=$tpl_content?>
	</section>
	<section class="article_comments" id="comments">
		<h2>Kommentare</h2>
		<?=$tpl_comments?>
	</section>
</article>