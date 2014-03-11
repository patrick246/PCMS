<h1>User hinzufügen</h1>
<form action='<?=$tpl_root?>admin/user/add' method="POST" class='form-horizontal' role='form'>
	<div class='form-group'>
		<label for='username' class='col-sm-2 control-label'>Username</label>
		<div class='col-sm-10'>
			<input type='text' name='username' class='form-control'>
		</div>
	</div>
	<div class='form-group'>
		<label for='pw' class='col-sm-2 control-label'>Passwort</label>
		<div class='col-sm-10'>
			<input type='password' name='pw' class='form-control'>
		</div>
	</div>
	<div class='form-group'>
		<label for='pw_repeat' class='col-sm-2 control-label'>Passwort wiederholen</label>
		<div class='col-sm-10'>
			<input type='password' name='pw_repeat' class='form-control'>
		</div>
	</div>
	<div class='form-group'>
		<label for='email' class='col-sm-2 control-label'>Email</label>
		<div class='col-sm-10'>
			<input type='text' name='email' class='form-control'>
		</div>
	</div>
	<div class='form-group'>
		<label for='role' class='col-sm-2 control-label'>Rolle</label>
		<div class='col-sm-10'>
			<select name='role' class='form-control'>
				<?=$tpl_accesslevels?>
			</select>
		</div>
	</div>
	<div class='form-group'>
		<div class='col-sm-offset-2 col-sm-10'>
			<button type='submit' class='btn btn-default'>
				Erstellen
			</button>
		</div>
	</div>
</form>