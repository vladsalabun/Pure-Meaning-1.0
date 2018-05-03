<?php 

	/*		
		To run cron use get params.
		Example:
		cron.php?do=check_group_subs
		
	*/
	
	require "configuration.php";
	require "classes_pm/class_model.php";
	require "classes_pm/class_controller.php";
	
	$cron = new cron;
	
	// if method don't exist, redirect to main url:
	$cron->checkAction();
