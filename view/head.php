<?php 
memory_get_usage(); 
$start_time = microtime(true);?><!DOCTYPE html>
<html lang="ru">
<head><?php $title = $pure->generatePageTitle(); if ( strlen($title)> 0 ) { $space = ' | ';} else { $space = ''; } ?>
<title><?php echo $title.$space; ?>Pure meaning 1.0</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<link href="<?php echo CONFIGURATION::MAIN_URL; ?>css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo CONFIGURATION::MAIN_URL; ?>css/pm_style.css" type="text/css" media="screen" />
</head>
<body>
<div class="navbar navbar-inverse navbar-static-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#responsive-menu">
				<span class="sr-only">XXX</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo CONFIGURATION::MAIN_URL;?>">Pure Meaning 1.0</a>
		</div>
		<div class="collapse navbar-collapse" id="responsive-menu">
			<ul class="nav navbar-nav"> 
			<?php 
				foreach ( CONFIGURATION::ALL_PAGES AS $menu_url => $menu_title )
				{
			?>
					<li><a href="<?php echo CONFIGURATION::MAIN_URL.'?page='.$menu_url; ?>"><?php echo $menu_title ;?></a></li>
			<?php
				}
			?>
			</ul>
		</div>
	</div>
</div>
<div class="container">
	<div id="navigation">

	</div>
