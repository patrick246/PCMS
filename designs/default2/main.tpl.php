<!DOCTYPE html>
<html>
<head>
	<title><?=$tpl_title?></title>
	<link rel='stylesheet' href='<?=$tpl_root?>designs/default2/css/main.css'>
	<!-- Module and Plugin Stylesheets -->
	<?php foreach($tpl_css as $css) echo $css;?>
	<!-- End Module and Plugin Stylesheets -->
	
	<!-- Module Meta -->
	<?php foreach ($tpl_meta as $meta) echo $meta;?>
	<!-- End Module Meta -->
</head>
<body>
	<header>
		<div class='overlay_header'>
			<div class='container'>
				<h1 class='pagetitle'><?=$tpl_header?></h1>
			</div>
		</div>
	</header>
	<nav>
		<div class='container'>
			<ul>
				<?php 
					foreach ($tpl_menu as $entry)
					{
				?>
						<li><a href='<?=$entry->link?>'><?=$entry->text?></a></li>
				<?php 
					}
				?>
			</ul>
		</div>
	</nav>
	<div class='middle'>
		<div class='container'>
			<div class='content'>
				<?=$tpl_content?>
			</div>
			<div class='sidebar_right'>
				<div class='sidebar_box1'>
					<?=$tpl_sidebarBox1?>
				</div>
				<div class='sidebar_box2'>
					<?=$tpl_sidebarBox2?>
				</div>
			</div>
		</div>
	</div>
	<div class='footer'>
		<div class='container'>
			Design &copy; by patrick246, 2014; CMS &copy; by patrick246, 2014 
		</div>
	</div>
</body>
</html>