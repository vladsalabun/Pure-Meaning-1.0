<script type='text/javascript' src='js/screenshotter.js'></script>
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script type='text/javascript' src='js/jquery-editable-select.js'></script>
<link rel="stylesheet" href="<?php echo CONFIGURATION::MAIN_URL; ?>css/jquery-editable-select.css" type="text/css" media="screen" />
<div class="row">
    <div class="col-lg-4">
<?php 
    
    echo p('← <a href="'.CONFIGURATION::MAIN_URL.'?page=memes">Memes</a>');
    echo p('<a href="" id="megaButton" class="reader" onclick="makeIT();">Download image</a>');
    
    // TODO:
    /*
    
        1. Форму зміни стилей з підказками
        2. На flex!
        3. Рандомний колір і фон, щоб записувати вдалі і невдалі пари у базу знань
        4. Збереження по CTRL+S
       
    */   
    
    $fonts = new fonts;
    $meme = $pure->getMeme($_GET['ID']);
    $style = json_decode($meme['style'],true);
    
    // walk through styles and get all fonts:
    $fontFaceArray = array();
    
    if (count($style['css']['id']) > 0) {
        foreach ($style['css']['id'] as $blockName => $blockCssArray) {
            if(isset($blockCssArray['font-family'])) {
                $fontFaceArray[] = $blockCssArray['font-family'];
            }
        }
    }
    if (count($style['css']['class']) > 0) {
        foreach ($style['css']['class'] as $blockName => $blockCssArray) {
            if(isset($blockCssArray['font-family'])) {
                $fontFaceArray[] = $blockCssArray['font-family'];
            }
        }
    }
    
    echo '<style>';
    // get fonts info by font name, and plug them:
    foreach ($fontFaceArray as $fontFaceName){
        $fontFace = $fonts->getFontByName($fontFaceName);        
        echo ' @font-face { font-family: '.$fontFace['fontFamily'].'; src: url('.configuration::MAIN_URL.'/uploads/fonts/'.$fontFace['fileName'].'); }';
    }
    echo '</style>';
    
    

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
            $mw->a('addcss','add css'),
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
                            '.$mw->a('addto_id_'.$idName,'add').' / 
                            '.$mw->a('delete_id_'.$idName,'del')
                        )
                    );
                // show all ID style:
                foreach ($idCss as $idCssName => $idCssValue) {
                    
                    if ($idCssName == 'font-family') {
                        echo $table->tr(
                        array(
                            $idCssName,
                            $form->fontSelectingForm($idCssValue,'id_'.$idName.'_'.$idCssName),
                            $mw->a('delete_id_'.$idName.'_css_'.$idCssName,'x')
                            )
                        );
                        
                    } else {
                        echo $table->tr(
                        array(
                            $idCssName,
                            $form->text(array('name' => 'id_'.$idName.'_'.$idCssName, 'value' => $idCssValue, 'class' => 'txtfield')),
                            $mw->a('delete_id_'.$idName.'_css_'.$idCssName,'x')
                            )
                        );
                    }
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
                            <a href="" data-toggle="modal" data-target="#delete_class_'.$idName.'">del</a>',
                            ''
                        )
                    );
                // show al ID style:
                foreach ($idCss as $idCssName => $idCssValue) {
                    if ($idCssName == 'font-family') {
                        echo $table->tr(
                        array(
                            $idCssName,
                            $form->fontSelectingForm($idCssValue,'class_'.$idName.'_'.$idCssName),
                            $mw->a('delete_class_'.$idName.'_css_'.$idCssName,'x')
                            )
                        );
                    } else {
                        echo $table->tr(
                        array(
                            $idCssName,
                            $form->text(array('name' => 'class_'.$idName.'_'.$idCssName, 'value' => $idCssValue, 'class' => 'txtfield')),
                            $mw->a('delete_class_'.$idName.'_css_'.$idCssName,'x')
                            )
                        );
                    }
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
	<div class="col-lg-8">
    <?php       

    // show meme style:
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

    echo $pure->modalHtml('canvas','Download canvas:','<div id="f"></div>'); 
    
    // SHOW MEME:
    echo $style['html'];
?>
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
            
            $currentCssKeys = array();
            // adding form:
            $AddToModalBody = $form->formStart()
            .$form->hidden(array('name' => 'action', 'value' => 'meme_add_style'))
            .$form->hidden(array('name' => 'ID','value' => $_GET['ID']))
            .$form->hidden(array('name' => 'type', 'value' => $type))
            .$form->hidden(array('name' => 'name', 'value' => $value));

            $currentCssKeys = array_keys($style['css'][$type][$value]);
            
            $AddToModalBody .= p('<p><select name="option[]">');
            
            // check block styles:
            foreach(configuration::STYLE as $styleOption => $styleParams) {
                // new style which can be selecter
                if (!in_array($styleOption,$currentCssKeys)) {
                    $AddToModalBody  .= '<option value="'.$styleOption.'">'.$styleOption.'</option>';
                } else {
                    
                    // if style is already selected, show modal to delete it:
                    $deleteBlockStyleBody = 
                     $form->formStart()
                    .$form->hidden(array('name' => 'action', 'value' => 'meme_delete_block_style'))
                    .$form->hidden(array('name' => 'ID','value' => $_GET['ID']))
                    .$form->hidden(array('name' => 'type','value' => $type))
                    .$form->hidden(array('name' => 'name','value' => $value))
                    .$form->hidden(array('name' => 'style','value' => $styleOption))
                    .$form->submit(array('name' => 'submit', 'value' => 'Delete '.$styleOption, 'class' => 'btn'))
                    .$form->formEnd();
                    
                    echo modalWindow('delete_'.$type.'_'.$value.'_css_'.$styleOption,'Delete style: <b>'.$styleOption.'</b> from '.$type.': <b>'.$value.'</b>',$deleteBlockStyleBody);
                    
                }
            }
            
            $AddToModalBody .= '</select></p>'
            .p('Enter value:')
            .p($form->text(array('name'=>'value','value' => '','class'=>'txtfield')));
            
            
            // adding form:
            $AddToModalBody .=
             $form->submit(array('name' => 'submit', 'value' => 'Add style', 'class' => 'btn'))
            .$form->formEnd();
            
            
            // delete form:
            $deleteModalBody = $form->formStart()
                .$form->hidden(array('name' => 'action', 'value' => 'meme_delete_block'))
                .$form->hidden(array('name' => 'ID', 'value' => $_GET['ID']))
                .$form->hidden(array('name' => 'type', 'value' => $type))
                .$form->hidden(array('name' => 'name', 'value' => $value))
                .$form->submit(array('name' => 'submit', 'value' => 'Delete', 'class' => 'btn'))
                .$form->formEnd();
            
            // deleting all css modal:
            echo modalWindow('delete_'.$type.'_'.$value,'Do you want to delete '.$type.' <b>'.$value.'</b>?',$deleteModalBody);
            
            // adding css modal: 
            echo modalWindow('addto_'.$type.'_'.$value,'Add style to '.$type.' <b>'.$value.'</b>?',$AddToModalBody);
        }
    }
   
    // ADD CSS:
    $AddCssBody = 
         $form->formStart()
        .$form->hidden(array('name' => 'action','value' => 'add_css_to_meme'))
        .$form->hidden(array('name' => 'ID','value' => $_GET['ID']))
        .p('Type <b>#idName</b> or <b>.className:</b>')
        .p($form->text(array('name'=>'value','value' => '','class'=>'txtfield')))
        .p($form->submit(array('name' => 'submit', 'value' => 'Add', 'class' => 'btn')))
        .$form->formEnd();
        
    echo modalWindow('addcss','Add css:',$AddCssBody);
    
?>