<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Fehler </title>
		<meta name="description" content="">
		<meta name="author" content="Patrick">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">
		<?php foreach ($tpl_meta as $meta) echo $meta;?>

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		<link rel="stylesheet" href="<?=$tpl_root?>designs/default_white_blue/css/error.css">
	</head>

	<body>
		<h1><?=$tpl_error_code?></h1>
		<p><?=$tpl_error_description?></p>
	</body>
</html>
