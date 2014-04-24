<div class='comment_entry'>
	<div class="comment_header">
		<img src="<?=$tpl_profile_pic?>" alt='<?=$tpl_username?>' class='profile_picture'>
		
		<a href="<?=$tpl_homepage?>"><?=$tpl_username?></a><br>
		
		<?=$tpl_date?><br>
		<?php if(!$tpl_approved) { ?>
			<i>Nicht freigeschaltet</i>
		<?php } ?>
	</div>
	<div class="comment_content">
		<?=$tpl_content?>
	</div>
	<?php if($tpl_can_approve || $tpl_can_edit || $tpl_can_delete) { ?>
		<div class="comment_mod_menu">
			<?php if($tpl_can_approve) { ?>
				<a href=''>
					<?php if(!$tpl_approved){?>
						Freischalten
					<?php } else { ?>
						Verstecken
					<?php } ?>
				</a> &bull;
			<?php } ?>
			<?php if($tpl_can_approve) { ?> 
				<a href=''>Bearbeiten</a> &bull;
			<?php } ?>
			<?php if($tpl_can_approve) { ?> 
				<a href=''>Löschen</a>
			<?php } ?>
		</div>	
	<?php } ?>
</div>
