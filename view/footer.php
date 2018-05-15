<?php 
    if($_GET['page'] === 'preview') {
        
    } else {
?>
<div id="footer">
	<div id="footer_inner">
		Чистый смысл.
	</div>
</div>
</div>
<br>
<?php 
		$memory = (!function_exists('memory_get_usage')) ? '' : round(memory_get_usage()/1024/1024, 2);
		$end_time = microtime(true);
		echo round(($end_time-$start_time),3).' cек. ' . $memory . ' МБ'; 
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
    $backgroundColors = array(
        // background => font color
        '#559E54' => '#F7E7D4',
        '#FF6633' => '#FFFFFF',
        '#C21460' => '#F7E7D4',
        '#e6e6e6' => '#1258DC',
        '#1258DC' => '#e6e6e6',
        '#669999' => '#FFFFFF',
        '#1258DC' => '#00CCFF',
        '#1258DC' => '#00CCFF'
    );
    
    $d1 = array_rand($backgroundColors);
    $color1 = $backgroundColors[$d1];
    $background1 = array_search($color1, $backgroundColors);
            
    echo '<style>
    .navbar {background: '.$background1.';} 
    .navbar-inverse .navbar-nav > li > a  {color: '.$color1.'; }
    .navbar-inverse .navbar-brand  {color: '.$color1.'; }
    .navbar { border: none;}
    
    #footer {background: '.$background1.';} 
    #footer_inner {color: '.$color1.'; } 
</style>
';

?>
</body>
</html>
    <?php } ?>