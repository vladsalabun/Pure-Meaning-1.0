<?php 
    if($_GET['page'] === 'preview') {
        
    } else if ($_GET['page'] === 'edit_element') {
?>
<script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="js/bootstrap.js"></script>
<script>
	$(document).ready(function()
	{
		$("body").css("display","none").fadeIn("slow");
	});
</script>
<?php    
    } else {
?>

</div>
<div class="container-fluid">
<?php 
    $myExp = $experience->allExp();
    foreach (configuration::LEVEL as $level => $levelExp) {
        if ($myExp > $levelExp) {
            $myLevel = $level;
        }
    }
    
    if ($myLevel < 20) {
        $designerClass = 'Junior';
    } else if ($myLevel >= 20 and $myLevel < 40) {
        $designerClass = 'Middle';
    } else if ($myLevel >= 40 and $myLevel < 76) {
        $designerClass = 'Senior';
    } else {
        $designerClass = 'God';
    }
    
    $delta = $myExp - configuration::LEVEL[$myLevel];
    $needExp = configuration::LEVEL[($myLevel + 1)];
    echo '<div id="level">'.$designerClass.' Designer: <b>'.$myLevel.'</b> lvl, '.round(($delta / $needExp * 100),2).'%<div id="level_complete" style="margin-top: -24px; background: #306eba; width: '.round(($delta / $needExp * 100),2).'%; height: 23px;"></div>';
    echo '<p align="left">';
    
?>    
</div>
<br>
<?php 
	
        $memory = (!function_exists('memory_get_usage')) ? '' : round(memory_get_usage()/1024/1024, 2);
		$end_time = microtime(true);
		echo '<!--- '.round(($end_time-$start_time),3).' cек. ' . $memory . ' МБ --->'; 
    
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
<?php } ?>