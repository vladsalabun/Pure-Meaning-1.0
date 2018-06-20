<script type='text/javascript' src='js/screenshotter.js'></script>
<div class="row">
    <div class="col-lg-3">
    <p><a href="" id="megaButton" class="reader" onclick="makeIT();">Download image</a></p>
    <?php
    
    $HtmlFormatter = new HtmlFormatter;
    
    $meme = $pure->getMeme($_GET['ID']);
    $style = json_decode($meme['style'],true);

    echo 
     $form->formStart()
    .$form->hidden(array('name' => 'action', 'value' => 'meme_update'))
    .$form->hidden(array('name' => 'ID', 'value' => $_GET['ID']))
    .$table->tableStart( array(
                'class'=>'table table-sm table-mini',
                'th'=> array('Name:','Params:'))
        )
    .$table->tr(
        array(
            'Name:',
            $form->text(array('name' => 'name', 'value' => $meme['name'], 'class' => 'txtfield'))
            )
        )
    .$table->tr(
        array(
            array(
                // colspan = 2:
                2,$form->textarea(array('name' => 'html', 'value' => $style['html'], 'class' => 'memetextarea')))
            )
        );

    foreach($style['css'] as $type => $typeArray) {
        $styleString = ''; 
        // get all identifiers:
        if ($type == 'id') {
            
            // walk through one identifier:
            foreach ($typeArray as $idName => $idCss) {
                
                echo $table->tr(
                    array(
                            '',
                            '<br><br><b>#'.$idName.'</b> (<a href="">x</a>)'
                        )
                    );
                
                // show al ID style:
                foreach ($idCss as $idCssName => $idCssValue) {
                    echo $table->tr(
                    array(
                        $idCssName,
                        $form->text(array('name' => 'id_'.$idName.'_'.$idCssName, 'value' => $idCssValue, 'class' => 'txtfield'))
                        )
                    );
                }
            }
            
        } else if ($type == 'class') {
            // get all classes:
            // walk through one identifier:
            foreach ($typeArray as $idName => $idCss) {
                
                echo $table->tr(
                    array(
                            '',
                            '<br><br><b>.'.$idName.'</b>'
                        )
                    );
                
                // show al ID style:
                foreach ($idCss as $idCssName => $idCssValue) {
                    echo $table->tr(
                    array(
                        $idCssName,
                        $form->text(array('name' => 'class_'.$idName.'_'.$idCssName, 'value' => $idCssValue, 'class' => 'txtfield'))
                        )
                    );
                }
            }
        }
    }



    echo $table->tr(
        array(
            '',
            $form->submit(array('name' => 'submit', 'value' => 'Update meme', 'class' => 'btn'))
            )
        ) 

    .$table->tableEnd()
    .$form->formEnd();
        
    
    ?>
    </div>
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
        

        // TODO:
        /*
        1. Копірайт на мем
        2. Наступний-попередній мем
        3. Форму зміни стилей з підказками
        4. Парсер html
        5. На flex!
        */

        // show meme:
        echo $style['html'];
        
        //$pure->updateMeme(1,'test',$style);
        
        echo '<style>';
        
        foreach($style['css'] as $type => $typeArray) {
            
            $styleString = '';
            // get all identifiers:
            if ($type == 'id') {
                // walk throught one identifier:
                foreach ($typeArray as $idName => $idCss) {
                    $styleString .= '#' . $idName.' {';
                        // show al ID style:
                        foreach ($idCss as $idCssName => $idCssValue) {
                            $styleString .= $idCssName . ': ' . $idCssValue. '; ';
                        }
                    $styleString .= '} ';
                }
            } else if ($type == 'class') {
                // get all classes:
                // walk throught one identifier:
                foreach ($typeArray as $className => $classCss) {
                    $styleString .= '.' . $className.' {';   
                    foreach ($classCss as $styleName => $styleValue) {
                        $styleString .= $styleName . ': ' . $styleValue. '; ';
                    }
                    $styleString .= '} ';
                }
            }
            // show:
            echo $styleString;
        }
        
        echo '</style>';   

                
        
        
    ?>
    <?php echo $pure->modalHtml('canvas','Download canvas:','<div id="f"></div>'); ?>
    <?php $style['html'];?>
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