<?php 

	class router
	{
		static public function start() 
		{
			// Create controller object:	
			$pure = new pure;
			// I ask which page to display:
			$need_page = $pure->checkPage();
			
			// if there is no POST request, we can show page:
			require 'view/head.php';
			require 'view/'.$need_page.'.php';
			require 'view/footer.php';
		}
	}
