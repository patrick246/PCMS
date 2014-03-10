<h2>Artikel hinzufügen</h2>
<form class='form-horizontal' action='/<?=$tpl_root?>/admin/article/addProcess' method="post">
	<div class='form-group'>
		<label for='name' class='col-sm-2 control-label'>Artikelname</label>
		<div class='col-sm-10'>
			<input type='text' name='name' class='form-control' placeholder='Artikelname...'>
		</div>
	</div>
	<div class='form-group'>
		<label for='urltitle' class='col-sm-2 control-label'>URL-Titel</label>
		<div class='col-sm-10'>
			<input type='text' name='urltitle' class='form-control' placeholder='URL-Titel...'>
		</div>
	</div>
	<div class='form-group'>
		<label for='name' class='col-sm-2 control-label'>Autor</label>
		<div class='col-sm-10'>
			<select name='author' class='form-control'>
				<?php
					foreach ($tpl_users as $user)
					{
				?>
					<option value='<?=$user->id?>'><?=$user->name?></option>
				<?php
					}
				?>
			</select>
		</div>
	</div>
	<div class='form-group'>
		<label for='name' class='col-sm-2 control-label'>Rolle</label>
		<div class='col-sm-10'>
			<select name='role' class='form-control'>
				<?php 
					foreach($tpl_roles as $role)
					{
				?>
					<option value='<?=$role->id?>'><?=$role->name?></option>
				<?php 
					}
				?>
			</select>
		</div>
	</div>
	<div class='form-group'>
		<label for='name' class='col-sm-2 control-label'>Inhalt</label>
		<div class='col-sm-10'>
			<textarea name='content' class='form-control' rows='15'></textarea>
		</div>
	</div>
	<div class='form-group'>
		<div class='col-sm-2 col-sm-offset-2'>
			<button type='submit' class='btn btn-primary'>
				Absenden
			</button>
		</div>
	</div>
</form>