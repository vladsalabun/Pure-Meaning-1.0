<script type='text/javascript' src='js/screenshotter.js'></script>
<div class="row">
	<div class="col-lg-12">
    <?php 
        $memeParam = array(
            'width' => 700,
            'height' => 500,
        );
    ?>
    
    <p><a href="" id="megaButton" class="reader" onclick="makeIT();">Download image</a></p>
       <div id="capture" 
       style="background: #f5da55; 
       width: <?php echo $memeParam['width']?>px; 
       height: <?php echo $memeParam['height']?>px; 
       padding: 0px; 
       font-size: 17px; 
       font-family: Arial; 
       text-align: center; 
       ">
       <br><br><br>
            <p>
                Як світло проб'ється через наші штори<br>
                А поки ще темно є в нашій кімнаті
            </p>
            <h2>Буффало</h2>
        </div>
    </div>
</div>
<script>

    html2canvas(document.querySelector("#capture"),{width:<?php echo $memeParam['width']?>,height:<?php echo $memeParam['height']?>,scale:1}).then(canvas => {
        document.body.appendChild(canvas);
    });
 
    function makeIT()
    { 
        // take first canvas:
        var canvas = $("canvas")[0];
        // get image in base64:
        var data = canvas.toDataURL('image/png').replace(/data:image\/png;base64,/, '');
        
        //все возникшие проблемы решились удалением canvas
        $('canvas').remove();
        
        //засылаем картинку на сервер
        
        $.post('<?php configuration::MAIN_URL;?>',{data:data, 'action':'meme_screenshot'}, function(rep){
             //alert('Image saved!');
        });
    }

</script>
