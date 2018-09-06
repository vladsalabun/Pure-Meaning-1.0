<?php 
    $fonts = new fonts;   
?>
<div class="row">
	<div class="col-lg-8 col-sm-9">
    <?php 
        $fontsArray = $fonts->getAllFonts();
        
        echo $table->tableStart( array(
                'class'=>'table table-striped',
                'th'=> array('ID:','Fav:','Family:','Cyr:','Lat','Type:')
                )
            );
        
        foreach ($fontsArray as $font) {
            
            $favForm = $form->formStart(array('id'=>'make_font_favourite'.$font['ID']));
            $favForm .= $form->hidden(array('name' => 'action','value' => 'make_font_favourite2'));
            $favForm .= $form->hidden(array('name' => 'fontID','value' => $font['ID']));
            
            
            // Favourite:
            if ($font['myFavourite'] == 0) {
                $favForm .= $form->hidden(array('name' => 'myFavourite','value' => 1));
                $favForm .= $icon->showIcon('empty-heart','width20 pointer','Not favourite','onclick="document.getElementById(\'make_font_favourite'.$font['ID'].'\').submit();"');
            } else if ($font['myFavourite'] == 1) {
                $favForm .= $form->hidden(array('name' => 'myFavourite','value' => 0));
                $favForm .= $icon->showIcon('heart','width20 pointer','Favourite','onclick="document.getElementById(\'make_font_favourite'.$font['ID'].'\').submit(); "');
                
            }
            $favForm .= $form->formEnd();
 // check          
            // Cyrillic:
            if ($font['cyrillic'] == 0) {
                $cyr = $icon->showIcon('no','width20 pointer','Cyrillic');
            } else if ($font['cyrillic'] == 1) {
                $cyr = $icon->showIcon('check','width20 pointer','Cyrillic');
            }
            
            // Latin:
            if ($font['latin'] == 0) {
                $latin = $icon->showIcon('no','width20 pointer','Latin');
            } else if ($font['latin'] == 1) {
                $latin = $icon->showIcon('check','width20 pointer','Latin');
            }   

            // SHOW table:
            echo $table->tr(
                array(
                    $font['ID'],
                    $favForm,
                    '<a href="'.CONFIGURATION::MAIN_URL.'?page=font&ID='.$font['ID'].'">'.$font['fontFamily'].'</a>',
                    $cyr,
                    $latin,
                    $font['fileType']
                )
            );
        }
        echo $table->tableEnd();
    
    ?>
    </div>
	<div class="col-lg-4 col-sm-3">
    <h4>Add new font:</h4>
<?php

    echo 
     $form->formStart(array('enctype' => 'multipart/form-data'))
    .$table->tableStart(array('class'=>'table table-striped','th'=> array('')))
    .$form->hidden(array('name' => 'action','value' => 'add_new_font'))
    .$form->hidden(array('name' => 'MAX_FILE_SIZE','value' => '20485760'))
    .$table->tr(
            array(
                $form->uploadFile()
            )
        )
     .$table->tr(
            array(
                $form->submit(array('name' => 'submit','value' => 'Завантажити шрифт','class' => 'btn btn-success margin10'))
            )
      )
       
    .$table->tableEnd()
    .$form->formEnd();
    
?>
    <ol align="left">
        <li>Веб-типографіку книжкам і <a href="https://ru.wikipedia.org/wiki/%D0%A8%D1%80%D0%B8%D1%84%D1%82">вікіпедії</a></li>
        <li>Багато шрифтів не треба. Штук 20 вистачить, бо їх можна комбінувати. Головне, щоб якісні були.</li>
    </ol>
    </div>
</div>
<script>
$('.submit_btn').click(function(){
    $( '.test' ).append( '<input type="hidden" name="secret_place" value="pi">' );
});
</script>
