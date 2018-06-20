<script type='text/javascript' src='js/screenshotter.js'></script>
<div class="row">
    <div class="col-lg-3">
    <p><a href="" id="megaButton" class="reader" onclick="makeIT();">Download image</a></p>
    <?php
    
    // TODO:
    /*
        1. Копірайт на мем
        2. Наступний-попередній мем
        3. Форму зміни стилей з підказками
        4. На flex!
        5. Рандомний колір і фон, щоб записувати вдалі і невдалі пари у базу знань
        6. Як відкрити папку після завантаження мема? 
        7. Сторінка перегляду мемів
    */

    
    $meme = $pure->getMeme($_GET['ID']);
    $style = json_decode($meme['style'],true);

    echo 
     $form->formStart()
    .$form->hidden(array('name' => 'action', 'value' => 'meme_update'))
    .$form->hidden(array('name' => 'ID', 'value' => $_GET['ID']))
    .$table->tableStart( array(
                'class'=>'table table-sm table-mini',
                'th'=> array('','Params:',''))
        )
    .$table->tr(
        array(
            'Name:',
            $form->text(array('name' => 'name', 'value' => $meme['name'], 'class' => 'txtfield')),
            ''
            )
        )
    .$table->tr(
        array(
            array(
                // colspan = 2:
                2,$form->textarea(array('name' => 'html', 'value' => $style['html'], 'class' => 'memetextarea')))
            ),
            ''
        )
    .$table->tr(
        array(
            '',
            '<a href="" data-toggle="modal" data-target="#addcss">add css</a>',
            ''
        )
    );
        
    foreach($style['css'] as $type => $typeArray) {
        $styleString = ''; 
        // get all identifiers:
        if ($type == 'id') {
            // walk through one identifier:
            foreach ($typeArray as $idName => $idCss) {
                
                $modalsArray['id'][] = $idName;
                
                echo $table->tr(
                    array(
                            '',
                            '<br><br><b>#'.$idName.'</b>:   
                            <a href="" data-toggle="modal" data-target="#addto_id_'.$idName.'">add</a> / 
                            <a href="" data-toggle="modal" data-target="#delete_id_'.$idName.'">del</a>',
                            ''
                        )
                    );
                // show al ID style:
                foreach ($idCss as $idCssName => $idCssValue) {
                    echo $table->tr(
                    array(
                        $idCssName,
                        $form->text(array('name' => 'id_'.$idName.'_'.$idCssName, 'value' => $idCssValue, 'class' => 'txtfield')),
                        'x'
                        )
                    );
                }
            }            
        } else if ($type == 'class') {
            // get all classes:
            // walk through one identifier:
            foreach ($typeArray as $idName => $idCss) {
                
                $modalsArray['class'][] = $idName;
                
                echo $table->tr(
                    array(
                            '',
                            '<br><br><b>.'.$idName.'</b>: 
                            <a href="" data-toggle="modal" data-target="#addto_class_'.$idName.'">add</a> / 
                            <a href="" data-toggle="modal" data-target="#delete_class_'.$idName.'">x</a>',
                            ''
                        )
                    );
                // show al ID style:
                foreach ($idCss as $idCssName => $idCssValue) {
                    echo $table->tr(
                    array(
                        $idCssName,
                        $form->text(array('name' => 'class_'.$idName.'_'.$idCssName, 'value' => $idCssValue, 'class' => 'txtfield'))
                        ),
                        'x'
                    );
                }
            }
        }
    }



    echo $table->tr(
        array(
            '',
            '<br><br>'.$form->submit(array('name' => 'submit', 'value' => 'Update meme', 'class' => 'btn')),
            ''
            )
        ) 

    .$table->tableEnd()
    .$form->formEnd();
        
    ?>
    </div>
	<div class="col-lg-9">
    <?php       

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

    html2canvas(document.querySelector("#capture"),{scale:1}).then(canvas => {
        //document.body.appendChild(canvas);
        document.getElementById('f').appendChild(canvas);
    });
 
    function makeIT()
    { 
        // take first canvas:
        var canvas = $("canvas")[0];
        // get image in base64:
        var data = canvas.toDataURL('image/png').replace(/data:image\/png;base64,/, '');
       
        //засылаем картинку на сервер
        $.post('<?php configuration::MAIN_URL;?>',{data:data, 'action':'meme_screenshot'}, function(rep){
             //alert('Image saved!');
        });
    }

</script>
<?php 
    foreach ($modalsArray as $type => $valuesArray) {
        foreach ($valuesArray as $value) {
            
            $AddToModalBody = $form->formStart()
            .$form->hidden(array('name' => 'action', 'value' => 'meme_add_style'))
            .$form->hidden(array('name' => 'type', 'value' => $type))
            .$form->hidden(array('name' => 'name', 'value' => $value))
            .$form->submit(array('name' => 'submit', 'value' => 'Add style', 'class' => 'btn'))
            .$form->formEnd();
            
            $deleteModalBody = $form->formStart()
                .$form->hidden(array('name' => 'action', 'value' => 'meme_delete_block'))
                .$form->hidden(array('name' => 'ID', 'value' => $_GET['ID']))
                .$form->hidden(array('name' => 'type', 'value' => $type))
                .$form->hidden(array('name' => 'name', 'value' => $value))
                .$form->submit(array('name' => 'submit', 'value' => 'Delete', 'class' => 'btn'))
                .$form->formEnd();
            
            echo $pure->modalHtml('delete_'.$type.'_'.$value,'Do you want to delete '.$type.' <b>'.$value.'</b>?',$deleteModalBody);
            echo $pure->modalHtml('addto_'.$type.'_'.$value,'Add style to '.$type.' <b>'.$value.'</b>?',$AddToModalBody);
        }
    }
    
    $AddCssBody = '';
    echo $pure->modalHtml('addcss','Add css:',$AddCssBody);
    
?>