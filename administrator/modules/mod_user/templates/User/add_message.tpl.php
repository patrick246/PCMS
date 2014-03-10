<?php 
if($tpl_status == 'success')
{
?>
<div class='alert alert-success'>
	<?=$tpl_message?>
</div>
<a href='/<?=$tpl_root?>/admin/user'>Zurück zur Userverwaltung</a><br>
<a href='/<?=$tpl_root?>/admin/user/detail/<?=$tpl_id?>'>User anzeigen</a>
<?php 
}
else
{
?>
<div class='alert alert-danger'>
	<strong>Da ging etwas schief...</strong><br>
	<ul>
		<?php 
			foreach($tpl_message as $message)
			{
			?>
				<li><?=$message?></li>
			<?php 	
			}
		?>
	</ul>
</div>
<a href='/<?=$tpl_root?>/admin/user'>Zurück zur Userverwaltung</a>
<?php
}
?>