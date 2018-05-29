<!DOCTYPE html>
<html lang="ru">
<head>
<title>Project Name</title>0
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<link href="css/bootstrap.css" rel="stylesheet">
<script>
function fresh() {
    location.reload();
}
setInterval("fresh()",10000);
</script>
<style>
<?php 
    // here i put generated CSS styles
?>
</style>
</head>
<body>

<!--- START HTML OUTPUT --->

<?php 

    // take all elements from database:
    $htmlTree = $pure->getDocumentTree($_GET['projectId']);

    if (count($htmlTree) > 0 ) {
    // clean them to make sure they are goot for use:
    $cleanArray = $pure->cleanLeaves($pure->createTreeArray($htmlTree));
    
    $HtmlFormatter = new HtmlFormatter;
    // show template:
    $document = $pure->createDocumentTree($cleanArray, NULL);
?>
<?php //echo $documentArray['css'];?>

<?php 
    echo HtmlFormatter::format($document);
    echo $pure->globalStyles($_GET['projectId']);
    }
?>


<!--- /END HTML OUTPUT --->

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


