<article class='mod_article_entry'>
	<div class='mod_article_info'>
		<h1><?=$tpl_title?></h1>
		Author: <?=$tpl_author?>
	</div>
	<hr>
	<div class='article_content'>
		<?=$tpl_content?>
	</div>
	<p>
	<?php if($tpl_link_to_article){?>
		<a href='/<?=$tpl_root?>/article/show/<?=$tpl_id?>'>Zum Artikel</a>
	<?php }?>
	</p>
</article>
<hr>