<h2>Artikel bearbeiten</h2>
<form class='form-horizontal' action='<?=$tpl_root?>admin/article/editProcess' method="post">
	<div class='form-group'>
		<label for='name' class='col-sm-2 control-label'>Artikelname</label>
		<div class='col-sm-10'>
			<input type='text' name='name' class='form-control' value='<?=$tpl_articlename?>'>
		</div>
	</div>
	<div class='form-group'>
		<label for='urltitle' class='col-sm-2 control-label'>URL-Titel</label>
		<div class='col-sm-10'>
			<input type='text' name='urltitle' class='form-control' value='<?=$tpl_urltitle?>'>
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
					<option value='<?=$user->id?>' <?=($tpl_checkedUser == $user->id)?'checked':''?>><?=$user->name?></option>
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
					<option value='<?=$role->id?>' <?=($tpl_checkedRole == $role->id)?'checked':''?>><?=$role->name?></option>
				<?php 
					}
				?>
			</select>
		</div>
	</div>
	<div class='form-group'>
		<label for='name' class='col-sm-2 control-label'>Inhalt</label>
		<div class='col-sm-10'>
			<textarea name='content' class='form-control'><?=$tpl_content?></textarea>
		</div>
	</div>
	<div class='form-group'>
		<div class='col-sm-2 col-sm-offset-2'>
			<button type='submit' class='btn btn-primary'>
				Absenden
			</button>
		</div>
	</div>
	<input type='hidden' name='article_id' value='<?=$tpl_id?>'>
</form>