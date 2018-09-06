<?php
memory_get_usage();


    $exp = rand(configuration::EXPERIENCE['LOAD']['min'],configuration::EXPERIENCE['LOAD']['max']);
    $experience = new experience;
    $experience->addExp($exp);

    $form = new formGenerator;
    $table = new tableGenerator;
    $mw = new modal;
    $icon = new icon;

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
<link href="<?php echo CONFIGURATION::MAIN_URL; ?>css/basic4.css" rel="stylesheet"> 
<!---  <link href="<?php echo CONFIGURATION::MAIN_URL; ?>css/bootstrap.css" rel="stylesheet"> --->

<link rel="stylesheet" href="<?php echo CONFIGURATION::MAIN_URL; ?>css/pm_style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo CONFIGURATION::MAIN_URL; ?>css/tables_style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo CONFIGURATION::MAIN_URL; ?>css/usefull.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo CONFIGURATION::MAIN_URL; ?>css/navbar_style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo CONFIGURATION::MAIN_URL; ?>css/modal_style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo CONFIGURATION::MAIN_URL; ?>css/links_style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo CONFIGURATION::MAIN_URL; ?>css/forms_style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo CONFIGURATION::MAIN_URL; ?>css/glyphicon.css" type="text/css" media="screen" />
<!--- <link href="https://fonts.googleapis.com/css?family=Alegreya|Merriweather|Old+Standard+TT|Roboto+Slab|Tinos" rel="stylesheet"> --->
</head>
<body>
<!--Main Navigation-->
<header>

    <nav class="navbar navbar-expand-lg navbar-dark">
       <a class="navbar-brand" href="<?php echo CONFIGURATION::MAIN_URL;?>">Pure Meaning <?php echo configuration::VER;?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
			<?php
				foreach ( CONFIGURATION::ALL_PAGES AS $menu_url => $menu_title )
				{
			?>
					<li><a href="<?php echo CONFIGURATION::MAIN_URL.'?page='.$menu_url; ?>" class="nav-link"><?php echo $menu_title ;?></a></li>
			<?php
				}
			?>
            </ul>
            <ul class="navbar-nav nav-flex-icons">
                <li class="nav-item">
                    <a class="nav-link"><i class="fa fa-facebook"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"><i class="fa fa-twitter"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"><i class="fa fa-instagram"></i></a>
                </li>
            </ul>
        </div>
    </nav>

</header>
<!--Main Navigation-->







<div class="container-fluid margin30">

    <?php } ?>
