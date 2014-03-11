<!DOCTYPE html>
<html>
<head>
	<title>Fehler - Administration</title>
	<link rel='stylesheet' href='<?=$tpl_root?>administrator/designs/bootstrap/css/bootstrap.min.css'>
	<link rel='stylesheet' href='<?=$tpl_root?>administrator/designs/bootstrap/css/bootstrap-theme.min.css'>
	<script src='<?=$tpl_root?>administrator/designs/bootstrap/js/jquery-2.0.3.min.js'></script>
	<script src='<?=$tpl_root?>administrator/designs/bootstrap/js/bootstrap.min.js'></script>
	<meta charset='utf-8'>
	<style>
		body 
		{
			padding-top: 50px; 
			padding-bottom: 20px;
		}
	</style>
</head>
	<div class='navbar navbar-inverse navbar-fixed-top' role='navigation'>
		<div class='container'>
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?=$tpl_root?>admin"><?=$tpl_pagetitle?></a>
			</div>
			<div class="navbar-collapse collapse">
			</div><!--/.navbar-collapse -->
		</div>
	</div>
	
	<div class='jumbotron'>
		<div class='container'>
			<h1><?=$tpl_error_code?></h1>
			<p><?=$tpl_error_description?></p>
			<a href='<?=$tpl_root?>admin'>Zurück zum Dashboard</a>
		</div>
	</div>
</html>