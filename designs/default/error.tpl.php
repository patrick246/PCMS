<!DOCTYPE html>
<html>
<head>
	<title>Fehler - <?=$tpl_pagetitle?></title>
	<link rel='stylesheet/less' href='/<?=$tpl_root?>/designs/default/css/error.less'>
	<script src='/<?=$tpl_root?>/designs/default/js/less-1.3.3.min.js'></script>
	
	<?php
		foreach ($tpl_meta as $meta) 
		{
			echo "\t".$meta;
		}
	?>
</head>
<body>
	<div class='container'>
		<h1><?=$tpl_error_code?></h1>
		<p><?=$tpl_error_description?></p>
	</div>
</body>
</html>