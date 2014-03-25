<!DOCTYPE html>
<html>
	<head>
		<title><?=$tpl_title?></title>
		<link rel="stylesheet" href="<?=$tpl_root?>designs/default_white_blue/css/main.css">
		<link rel="stylesheet" href="<?=$tpl_root?>designs/default_white_blue/css/1000_4_20.css" />
		<?php foreach($tpl_css as $css) echo $css;?>
		<?php foreach ($tpl_meta as $meta) echo $meta;?>
	</head>
	<body>
		<div id="nonFooter">
			<div class="navbar clearfix">
				<div class="container clearfix">
					<div class="navbar-brand">
						<?=$tpl_header?>
					</div>
					<ul class="navbar-nav">
						<?php foreach($tpl_menu as $entry){?>
							<li><a href="<?=$entry->link?>"><?=$entry->text?></a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<div class="container content">
				<div class="row">
					<div class="col gu3">
						<?=$tpl_content?>
					</div>
					<div class="col gu1">
						<div id="sidebarBoxOne">
							<?=$tpl_sidebarBox1?>
						</div>
						<div id="sidebarBoxTwo">
							<?=$tpl_sidebarBox2?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<footer class="row">
			<div class="container">
				<div class="col gu1">
					<h2>Über</h2>
					<ul>
						<li><a href="#">Über mich</a></li>
						<li><a href="#">Über das CMS</a></li>
						<li><a href="#">Impressum</a></li>
					</ul>
				</div>
				<div class="col gu1">
					<h2>Tolle Webseiten</h2>
					<ul>
						<li><a href="http://blackphantom.de/" target="_blank">Blackphantom.de</a></li>
						<li><a href="http://menzerath.eu/" target="_blank">Menzerath.eu</a></li>
						<li><a href="http://ratgeber---forum.de/" target="_blank">Das Ratgeber-Forum</a></li>
						<li><a href="http://thiefas.de/" target="_blank">Thiefas.DE</a></li>
					</ul>
				</div>
				<div class="col gu1">
					<h2></h2>
				</div>
			</div>
		</footer>
	</body>
</html>