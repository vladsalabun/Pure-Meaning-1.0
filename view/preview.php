<!DOCTYPE html>
<html lang="ru">
<head>
<title>Project Name</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<link href="css/bootstrap.css" rel="stylesheet">
<style>
<?php 
    // here i put generated CSS styles
?>
</style>
</head>
<body>
<?php 

    // take all elements from database:
    $htmlTree = $pure->getDocumentTree($_GET['projectId']);
    // clean them to make sure they are goot for use:
    $cleanArray = $pure->cleanLeaves($pure->createTreeArray($htmlTree));
    
    // show template:
    echo $pure->createDocumentTree($cleanArray, NULL);

?>

<script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="js/bootstrap.js"></script>
<script>
	$(document).ready(function()
	{
		$("body").css("display","none").fadeIn("slow");
	});
</script>
</body>
</html>


