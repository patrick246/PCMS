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
		<?php if(isset($tpl_errors) && count($tpl_errors)) { ?>
			<div class="red_alert">
				<h4>Es sind folgende Fehler aufgetreten: </h4>
				<ul>
				<?php foreach($tpl_errors as $error) { ?>
					<li><?=$error?></li>
				<?php } ?>
			</div>
			<script>
				location.hash = 'comments';
			</script>
		<?php } ?>
		<?php if(isset($tpl_success) && $tpl_success) { ?>
			<div class="green_alert">
				<h4>Der Kommentar wurde gespeichert</h4>
				<?php if(isset($tpl_needsApproval) && $tpl_needsApproval) { ?>
					<p>Ein Moderator oder Administrator wird deinen Kommentar in Kürze freischalten</p>
				<?php } ?>
			</div>
			<script>
				location.hash = 'comments';
			</script>	
		<?php } ?>
		<form action="<?=$tpl_root?>article/addComment/<?=$tpl_id?>" method="POST">
			<?php if(!$tpl_logged_on) { ?>
				<div class="form_row">
					<label for='username'>
						Username
					</label>
					<input type="text" name="username" placeholder="Anonymous" <?=(isset($tpl_username) ? 'value="'. $tpl_username . '"' : '')?>/>
				</div>
				<div class="form_row">
					<label for='email'>
						Email
					</label>
					<input type="email" name="email" placeholder="anonymous@example.com" <?=(isset($tpl_email) ? 'value="'. $tpl_email . '"' : '')?>/>
				</div>
				<div class="form_row">
					<label for='homepage'>
						Homepage
					</label>
					<input type="text" name="homepage" placeholder="www.example.com" <?=(isset($tpl_homepage) ? 'value="'. $tpl_homepage . '"' : '')?>/>
				</div>
			<?php } ?>
			
			<div class="form_row">
					<label for='content'>
						Inhalt
					</label>
					<textarea name='content'><?=(isset($tpl_comment_content) ? $tpl_comment_content : '')?></textarea>
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