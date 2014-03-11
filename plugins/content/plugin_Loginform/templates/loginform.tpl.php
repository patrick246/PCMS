<h2>Login</h2>
<form action='<?=$tpl_root?>login/process' method='post' class='plugin_loginform'>
	<div class='plugin_loginform_row'>
		<input type='text' name='username' placeholder='Username'>
	</div>
	<div class='plugin_loginform_row'>
		<input type='password' name='password' placeholder='Password'>
	</div>
	<div class='plugin_loginform_row'>
		<input type='submit' name='submit' value='Login'>
	</div>
</form>