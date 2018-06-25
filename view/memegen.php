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
            
            foreach(configuration::STYLE as $styleOption => $styleParams) {
                if (!in_array($styleOption,$currentCssKeys)) {
                    $AddToModalBody  .= '<option value="'.$styleOption.'">'.$styleOption.'</option>';
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