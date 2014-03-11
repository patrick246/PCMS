<h2>Login</h2>
<form action="<?=$tpl_root?>login/process" method="post" class='mod_login_form'>
	<div class='mod_login_row'>
		<label for='username'>Username</label>
		<input type='text' name='username' placeholder='Username...'>
	</div>
	<div class='mod_login_row'>
		<label for='password'>Password</label>
		<input type='password' name='password' placeholder='Password...'>
	</div>
	<div class='mod_login_row'>
		<input type='submit' value='Login'>
	</div>
	<br style='clear: both;'>
</form>