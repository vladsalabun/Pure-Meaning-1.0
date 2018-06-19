<script type='text/javascript' src='js/screenshotter.js'></script>
<div class="row">
	<div class="col-lg-9">
    <?php
        if(isset($_GET['width'])) {
            $width = $_GET['width'];
        } else {
            $width = 700;
        }
        if(isset($_GET['height'])) {
            $height = $_GET['height'];
        } else {
            $height = 500;
        }
        if(isset($_GET['font_size'])) {
            $font_size = $_GET['font_size'];
        } else {
            $font_size = 17;
        }    
        if(isset($_GET['font_family'])) {
            $font_family = $_GET['font_family'];
        } else {
            $font_family = 'Arial';
        }
        
        $meme = $pure->getMeme(1);
        var_dump($meme);
        
        $style = array(
            'html' => '<div id="capture">
            <br><br>
            <br><br>
            <br>
            <h2 id="one">Каждый раб хочет собственного раба</h2>
            <h2 id="two">Суп-пюре из ядерного гриба</h2>
            <h2 id="three">От короны тяжёлая голова</h3>
            <h2 id="four">По ночам детям зачитывают права </h3>            
            </div>',
            'css' => array(
                'id'=> array(
                    'capture' => array(
                        'background' => '#f5f5dc',
                        'width' => $width.'px',
                        'height' => $height.'px',
                        'padding' => '0px',
                        'font-size' => $font_size.'px', 
                        'font-family' => $font_family, 
                        'text-align' => 'center'
                    ),
                    'one' => array(
                        'color' => '#000',
                        'font-size' => '32px',
                        'font-style' => 'oblique'
                    ),
                    'two' => array(
                        'color' => '#000',
                        'font-size' => '32px',
                        'font-style' => 'oblique'
                    ),
                    'three' => array(
                        'color' => '#000',
                        'font-size' => '32px',
                        'font-style' => 'oblique'
                    ),
                    'four' => array(
                        'color' => '#000',
                        'font-size' => '32px',
                        'font-style' => 'oblique'
                    )
                ),
                'class' => array(
                    'className' => array(
                        'color' => '#000'
                    ),
                    'className2' => array(
                        'background' => '#000'
                    )
                )
            )
        );
        
        
        // TODO:
        /*
        1. Копірайт на мем
        */
        
        echo '<style>';
        
        foreach($style['css'] as $type => $typeArray) {
            
            $str = '';
            // get all identifiers:
            if ($type == 'id') {
                // walk throught one identifier:
                foreach ($typeArray as $idName => $idCss) {
                    $str .= '#' . $idName.' {';
                        // show al ID style:
                        foreach ($idCss as $idCssName => $idCssValue) {
                            $str .= $idCssName . ': ' . $idCssValue. '; ';
                        }
                    $str .= '} ';
                }
            } else if ($type == 'class') {
                // get all classes:
                // walk throught one identifier:
                foreach ($typeArray as $className => $classCss) {
                    $str .= '.' . $className.' {';   
                    foreach ($classCss as $styleName => $styleValue) {
                        $str .= $styleName . ': ' . $styleValue. '; ';
                    }
                    $str .= '} ';
                }
            }
            // show:
            echo $str;
        }
        
        echo '</style>';   

                
        
        
    ?>
    <?php echo $pure->modalHtml('canvas','Download canvas:','<div id="f"></div>'); ?>
    <?php echo $style['html'];?>
    </div>
    <div class="col-lg-3">
    <p><a href="" id="megaButton" class="reader" onclick="makeIT();">Download image</a></p>
    </div>
    
</div>
<script>

    html2canvas(document.querySelector("#capture"),{width:<?php echo $width; ?>,height:<?php echo $height; ?>,scale:1}).then(canvas => {
        //document.body.appendChild(canvas);
        document.getElementById('f').appendChild(canvas);
    });
 
    function makeIT()
    { 
        // take first canvas:
        var canvas = $("canvas")[0];
        // get image in base64:
        var data = canvas.toDataURL('image/png').replace(/data:image\/png;base64,/, '');
        
        //все возникшие проблемы решились удалением canvas
        //$('canvas').remove();
        
        //засылаем картинку на сервер
        
        $.post('<?php configuration::MAIN_URL;?>',{data:data, 'action':'meme_screenshot'}, function(rep){
             //alert('Image saved!');
        });
    }

</script>