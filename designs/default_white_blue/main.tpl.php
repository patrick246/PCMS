<!DOCTYPE html>
<html>
	<head>
		<title><?=$tpl_title?></title>
		<link rel="stylesheet" href="<?=$tpl_root?>designs/default_white_blue/css/main.css">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<?php foreach($tpl_css as $css) echo $css;?>
		<?php foreach ($tpl_meta as $meta) echo $meta;?>
		
		<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
		<link rel="icon" type="image/png" href="/favicon-196x196.png" sizes="196x196">
		<link rel="icon" type="image/png" href="/favicon-160x160.png" sizes="160x160">
		<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
		<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
		<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
		<meta name="msapplication-TileColor" content="#0099ff">
		<meta name="msapplication-TileImage" content="/mstile-144x144.png">
		
		 <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
		 <script>
		 	$(function(){
		 		
		 		if($(window).width() < 1000)
		 			$('.navbar-nav').hide();
		 		
		 		$('#displayNavigation').on('click', function(){
		 			$('.navbar-nav').fadeToggle();
		 		});
		 		
		 		$(window).on('resize', function(){
		 			if($(window).width() >= 1000)
		 				$('.navbar-nav').show();
		 			else 
		 				$('.navbar-nav').hide();
		 		});
		 	});
		 </script>
	</head>
	<body>
		<div id="nonFooter">
			<div class="navbar clearfix">
				<div class="container clearfix">
					<div class="navbar-brand">
						<h1>
							<a href="<?=$tpl_root?>"><?=$tpl_header?></a>
						</h1>
					</div>
					
					<ul class="navbar-nav">
						<?php foreach($tpl_menu as $entry){?>
							<li <?=($entry->type == 'dropdown')?'class="dropdown"':''?>>
								<a href="<?=$entry->link?>">
									<?=$entry->text?>
								</a>
								<?php if($entry->type == 'dropdown'){ ?>
									<ul>
										<?php foreach($entry->children as $child){ ?>
											<li><a href="<?=$child->link?>"><?=$child->text?></a></li>
										<?php } ?>
									</ul>
								<?php } ?>
							</li>
						<?php } ?>
					</ul>
					<button id="displayNavigation">Navigation umschalten</button>
				</div>
			</div>
			<div class="container content">
				<div class="row">
					<div class="col gu3">
						<?=$tpl_content?>
					</div>
					<div class="col gu1">
						<div id="sidebarBoxOne" class="sidebox">
							<?=$tpl_sidebarBox1?>
						</div>
						<div id="sidebarBoxTwo" class="sidebox">
							<?=$tpl_sidebarBox2?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<footer class="row">
			<?=$tpl_boxFooter?>
		</footer>
	</body>
</html>