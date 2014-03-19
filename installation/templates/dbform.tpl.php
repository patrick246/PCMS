<div class="container">
	<h1>Datenbankeinstellungen</h1>
	
	<?php if(isset($tpl_error))
	{
	?>
		<p class="alert alert-danger">Datenbankfehler. Bitte überprüfe deine Zugangsdaten. <br>PHP-Fehlermeldung: <?=$tpl_error?></p>	
	<?php
	}
	?>
	<form action="index.php?step=db" method="post" class="form-horizontal" style="width: 75%; margin: 0 auto;">
		<div class="form-group">
			<label for="host" class="col-sm-2 control-label">Datenbank-Host</label>
			<div class="col-sm-10">
				<input type="text" name="host" class="form-control" value="<?=(isset($tpl_host))?$tpl_host:'localhost'?>">
			</div>
		</div>
		
		<div class="form-group">
			<label for="dbuser" class="col-sm-2 control-label">Datenbank-User</label>
			<div class="col-sm-10">
				<input type="text" name="dbuser" class="form-control" value="<?=(isset($tpl_dbuser))?$tpl_dbuser:'root'?>">
			</div>
		</div>
		
		<div class="form-group">
			<label for="dbpw" class="col-sm-2 control-label">Datenbank-Passwort</label>
			<div class="col-sm-10">
				<input type="password" name="dbpw" class="form-control" value="<?=(isset($tpl_dbpw))?$tpl_dbpw:''?>">
			</div>
		</div>
		
		<div class="form-group">
			<label for="dbname" class="col-sm-2 control-label">Datenbankname</label>
			<div class="col-sm-10">
				<input type="text" name="dbname" class="form-control" value="<?=(isset($tpl_dbname))?$tpl_dbname:'pcms'?>">
			</div>
		</div>
		
		<div class="form-group">
			<label for="dbprefix" class="col-sm-2 control-label">Tabellenprefix</label>
			<div class="col-sm-10">
				<input type="text" name="dbprefix" class="form-control" value="<?=(isset($tpl_dbprefix))?$tpl_dbprefix:'pcms_'?>">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2">
				<button type="submit" class="btn btn-primary">Absenden</button>
			</div>
		</div>
	</form>
</div>