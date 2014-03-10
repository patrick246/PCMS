<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset='utf-8'>
	<link rel='stylesheet/less' type='text/css' href='/<?=$tpl_root?>/administrator/designs/default/default.less'>
	<script src='/<?=$tpl_root?>/administrator/designs/default/less-1.3.3.min.js'></script>
<?php
		foreach ($tpl_css as $css) {
			echo $css;
		}
?>
</head>
<body>
	<div class='container'>
		<div class='middle'>
			<div class='sidebar'>
				<ul>
				<?php
					foreach($tpl_menu as $entry)
					{
				?>
					<li><a href='/<?=$tpl_root?>/<?=$entry->link?>'><?=$entry->text?></a></li>
				<?php 
					}
				?>
				</ul>
			</div>
			<div class='content'>
				<?=$tpl_content?>
			</div>
		</div>
		<footer>
			CMS &copy; by Patrick Hahn
		</footer>
	</div>
</body>
</html>