<!DOCTYPE html>
<html>
	<head>
		<title><?=$tpl_title?></title>
		<link rel="stylesheet" href="<?=$tpl_root?>designs/default_white_blue/css/main.css">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<?php foreach($tpl_css as $css) echo $css;?>
		<?php foreach ($tpl_meta as $meta) echo $meta;?>
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