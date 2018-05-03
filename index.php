<?php 

	/*		
	*	This programm is usefull for create design patterns.	
	*/
	
	require "configuration.php";
	require "classes_pm/class_model.php";
	require "classes_pm/class_controller.php";
	
	require "router.php";
	
	router::start();
