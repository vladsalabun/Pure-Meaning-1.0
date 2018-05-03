
<div id="footer">
	<div id="footer_inner">
		Чистый смысл.
	</div>
</div>
</div>
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
</body>
</html>
