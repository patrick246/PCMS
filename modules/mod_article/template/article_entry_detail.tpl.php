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
	<section id="addComment">
		<h3>Gib deinen Senf dazu</h3>
		<form action="<?=$tpl_root?>article/addComment" method="POST">
			<?php if(!$tpl_logged_on) { ?>
				<div class="form_row">
					<label for='username'>
						Username
					</label>
					<input type="text" name="username" placeholder="Anonymous"/>
				</div>
				<div class="form_row">
					<label for='email'>
						Email
					</label>
					<input type="email" name="email" placeholder="anonymous@example.com"/>
				</div>
				<div class="form_row">
					<label for='homepage'>
						Homepage
					</label>
					<input type="text" name="homepage" placeholder="www.example.com"/>
				</div>
			<?php } ?>
			
			<div class="form_row">
					<label for='content'>
						Inhalt
					</label>
					<textarea name='content'></textarea>
			</div>
			<?php if($tpl_needs_captcha){ ?>
				<div class="form_row">
					<label for='captcha'>Captcha</label>
					<div class="form-control">
						<?=$tpl_captcha_code?>
					</div>
				</div>
			<?php } ?>	
			<?=CSRF::token()?>
			<input type="submit" value="Absenden">
		</form>
	</section>
</article>