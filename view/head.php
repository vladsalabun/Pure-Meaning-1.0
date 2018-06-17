<?php 
memory_get_usage(); 
$start_time = microtime(true); 
    if($_GET['page'] === 'preview') {
        
    } else {
?><!DOCTYPE html>
<html lang="ru">
<head><?php // TODO: generate TITLE! ?>
<title>Pure meaning <?php echo configuration::VER;?></title>
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
			<a class="navbar-brand" href="<?php echo CONFIGURATION::MAIN_URL;?>">Pure Meaning <?php echo configuration::VER;?></a>
		</div>
		<div class="collapse navbar-collapse" id="responsive-menu">
			<ul class="nav navbar-nav"> 
			<?php 
				foreach ( CONFIGURATION::ALL_PAGES AS $menu_url => $menu_title )
				{
			?>
					<li><a href="<?php echo CONFIGURATION::MAIN_URL.'?page='.$menu_url; ?>" class="headerlink"><?php echo $menu_title ;?></a></li>
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
    <?php } ?>
<?php 
    $exp = rand(configuration::EXPERIENCE['LOAD']['min'],configuration::EXPERIENCE['LOAD']['max']);
    $experience = new experience;
    $experience->addExp($exp);
    
    $form = new formGenerator;    
    $table = new tableGenerator;
    $mw = new modal;
?>