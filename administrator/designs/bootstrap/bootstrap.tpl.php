<!DOCTYPE html>
<html>
<head>
	<title><?=$tpl_title?></title>
	<link rel='stylesheet' href='/<?=$tpl_root?>/administrator/designs/bootstrap/css/bootstrap.min.css'>
	<link rel='stylesheet' href='/<?=$tpl_root?>/administrator/designs/bootstrap/css/bootstrap-theme.min.css'>
	<script src='/<?=$tpl_root?>/administrator/designs/bootstrap/js/jquery-2.0.3.min.js'></script>
	<script src='/<?=$tpl_root?>/administrator/designs/bootstrap/js/bootstrap.min.js'></script>
	<?=$tpl_js?>
	<meta charset='utf-8'>
	<style>
		body 
		{
			padding-top: 75px; 
			padding-bottom: 20px;
		}
	</style>
	<!-- Additional css files -->
	<?php
		foreach($tpl_css as $css)
		{
			echo $css;
		}
	?>
</head>
<body>
	<div class='navbar navbar-inverse navbar-fixed-top' role='navigation'>
		<div class='container'>
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/<?=$tpl_root?>/admin"><?=$tpl_pagetitle?></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class='nav navbar-nav navbar-left'>
					<?php
						foreach($tpl_menu as $entry)
						{
							if($entry->type == 'dropdown')
							{
								?>
									<li class='dropdown'>
										<a href='#' class='dropdown-toggle' data-toggle='dropdown'><?=$entry->text?> <b class='caret'></b></a>
										<ul class='dropdown-menu'>
										<?php 
											foreach($entry->children as $child)
											{
												//echo varDump($entry);
												?>
												<li><a href='<?=$child->link?>'><?=$child->text?></a></li>
												<?php 
											}
										?>
										</ul>
									</li>
								<?php 
							}
							else 
							{
								?>
									<li><a href='<?=$entry->link?>'><?=$entry->text?></a></li>
								<?php
							}
						}
					?>
				</ul>
				<p class='navbar-right navbar-text'>Eingeloggt als <?=$tpl_current_username?></p>
			</div><!--/.navbar-collapse -->
		</div>
	</div>
	
	<div class="container">
		
		<?=$tpl_content?>
		
		<hr>
	
		<footer>
			<p>&copy; by Patrick Hahn 2014</p>
		</footer>
	</div>
</body>
</html>