<!DOCTYPE html>
<html>
<head>

	<title>
		<?=$tpl_title?>
		
	</title>
<?php
		foreach ($tpl_meta as $meta) {
			echo "\t".$meta;
		}
?>
	
	<link rel='stylesheet/less' type='text/css' href='/<?=$tpl_root?>/designs/default/css/default.less'>
<?php
		foreach ($tpl_css as $css) {
			echo $css;
		}
?>
	
	<script src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
	<script src='/<?=$tpl_root?>/designs/default/js/less-1.3.3.min.js'></script>
	
</head>
<body>
<div class='container'>
	<header>
		<h1><?=$tpl_header?></h1>
	</header>
	<div class='middle'>
		<nav>
			<div class='box_aboveMenu'>
<?=$tpl_box_aboveMenu?>
			</div>
			<div class='menu'>
				<h2>Menu</h2>
				<ul>
<?php 
			foreach ($tpl_menu as $menuentry) {
?>
					<li><a href='<?=$menuentry->link?>'><?=$menuentry->text?></a></li>
<?php
			}
?>		
				</ul>
			</div>
			<div class='box_underMenu'>
<?=$tpl_box_underMenu?>
			</div>
		</nav>
		<article class='main'>
			<div class='box_aboveContent'>
				<?=$tpl_box_aboveContent?>
			</div>
			<?=$tpl_content?>
			<div class='box_underContent'>
				<?=$tpl_box_underContent?>
			</div>
		</article>
		<span style='clear: both'></span>
	</div>
	<footer>
		<?=$tpl_footer?>
		
		<div class='copyright'>
			&copy; 2013 by Patrick Hahn
		</div>
	</footer>
</div>
</body>
</html>