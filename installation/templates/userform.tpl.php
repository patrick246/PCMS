<div class="container">
	<h1>User-Einstellungen</h1>
	<form action="index.php?step=user" method="post" class="form-horizontal">
		<h3>Allgemeines</h3>
		<div class="form-group">
			<label for="homepage_name" class="col-sm-2 control-label">Seitentitel</label>
			<div class="col-sm-10">
				<input type="text" name="homepage_name" class="form-control" placeholder="Seitentitel...">
			</div>
		</div>
		
		<h3>Admin-Account</h3>
		<div class="form-group">
			<label for="admin_username" class="col-sm-2 control-label">Username</label>
			<div class="col-sm-10">
				<input type="text" name="admin_username" class="form-control" placeholder="Username...">
			</div>
		</div>
		
		<div class="form-group">
			<label for="admin_email" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10">
				<input type="text" name="admin_email" class="form-control" placeholder="Email...">
			</div>
		</div>
		
		<div class="form-group">
			<label for="admin_password" class="col-sm-2 control-label">Passwort</label>
			<div class="col-sm-10">
				<input type="password" name="admin_password" class="form-control">
			</div>
		</div>
		
		<div class="form-group">
			<label for="admin_password_repeat" class="col-sm-2 control-label">Passwortwiederholung</label>
			<div class="col-sm-10">
				<input type="password" name="admin_password_repeat" class="form-control">
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-sm-2 col-sm-offset-2">
				<button type="submit" class="btn btn-primary">Absenden</button>
			</div>
		</div>
		
	</form>
</div>
