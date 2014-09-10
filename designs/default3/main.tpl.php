<!DOCTYPE html>
<html>
<head>
	<title><?=$tpl_title?></title>

	<link rel="stylesheet" href="<?=myDir()?>css/default3.css">
	<?php foreach($tpl_css  as $css)    echo $css;  ?>
	<?php foreach($tpl_meta as $meta)   echo $meta; ?>
</head>
<body>
	<header>
		<ul class="nav">
			<li class="brand">
				<?=$tpl_header?>
			</li>
			<li>
				<a href="#">Home</a>
			</li>
			<li>
				<a href="#">Administration</a>
			</li>
		</ul>
	</header>

	<div class="main">
		<div class="container">
			<div class="aboveContent">
				Test above content
			</div>
			<div class="content">
				Test content
			</div>
			<div class="belowContent">
				Test below content
			</div>
		</div>

		<div class="side">
			<div class="box">
				Box 1
			</div>
			<div class="box">
				Box 2
			</div>
		</div>
	</div>
	<footer>
		&copy; <?=date('Y')?> by patrick246
	</footer>
</body>
</html>