<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Installation | PCMS</title>
		<meta name="description" content="">
		<meta name="author" content="Patrick">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		
		<link rel='stylesheet' href='<?=$tpl_root?>installation/templates/css/bootstrap.min.css'>
		<link rel='stylesheet' href='<?=$tpl_root?>installation/templates/css/bootstrap-theme.min.css'>
		<script src='<?=$tpl_root?>installation/templates/js/jquery-2.0.3.min.js'></script>
		<script src='<?=$tpl_root?>installation/templates/js/bootstrap.min.js'></script>
		
		<script>
			$(document).ready(function(){
				$(".nav li.disabled a").click(function(){
					return false;
				});
			});
		</script>
		<style>
			.navbar
			{
				margin-bottom: 0;
			}
		</style>
	</head>

	<body>
		<nav class='navbar navbar-default' role='navigation'>
			<div class='container'>
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="topnav-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand">PCMS</a>
				</div>
				<div class="collapse navbar-collapse" id="topnav-collapse">
					<ul class="nav navbar-nav">
						<li <?= ($tpl_step == 'start') ? 'class="active"' : '' ?>>
							<a href="index.php">
								Startseite
							</a>
						</li>
						<li <?=($tpl_step == 'check')?'class="active"':''?>>
							<a href="index.php?step=check">
								Check
							</a>
						</li>
						<li <?=($tpl_step=='db' || $tpl_step=='user')?'':'class="disabled"'?>
							<?=($tpl_step == 'db')?'class="active"':''?>	
						>
							<a href="index.php?step=db">
								DB-Daten
							</a>
						</li>
						<li <?=($tpl_step=='user')?'':'class="disabled"'?>
							<?=($tpl_step == 'user')?'class="active"':''?>
						>
							<a href="index.php?step=user">
								User-Einstellungen
							</a>
						</li>
						<li <?=($tpl_step=='finish')?'class="active"':'class="disabled"'?>>
							<a href="index.php?step=finish">
								Fertig
							</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
			
		<?=$tpl_content?>
		
	</body>
</html>
