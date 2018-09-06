<?php 
    if($_GET['page'] === 'preview') {
        
    } else if ($_GET['page'] === 'edit_element') {
?>
<script src="js/jQuery_v1.12.4.js"></script>
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
<div class="container-fluid workspace">

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
    echo '<div id="level">'.$designerClass.' Designer: <span class="fontB">'.$myLevel.'</span> lvl, '.round(($delta / $needExp * 100),2).'%<div id="level_complete" style="margin-top: -21px; background: #306eba; width: '.round(($delta / $needExp * 100),2).'%; height: 23px;"></div></div>';
    echo '';
    
?>    
<p align="left">

<p>Смисл цієї програми в економії часу та накопиченні знань.</p>
<p> © 2018 Web Cybernetica<br> Пошта: <a href="mailto:salabunvlad@gmail.com">salabunvlad@gmail.com</a><br> Дякую за те, що відвідали мій сайт! </p>
</div>
<?php 
	
        $memory = (!function_exists('memory_get_usage')) ? '' : round(memory_get_usage()/1024/1024, 2);
		$end_time = microtime(true);
		echo '<!--- '.round(($end_time-$start_time),3).' cек. ' . $memory . ' МБ --->'; 
    
?>

<script src="js/jQuery_v1.12.4.js"></script>
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