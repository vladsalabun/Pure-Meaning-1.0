<?php 
    $fonts = new fonts;
    $form = new formGenerator;    
    $table = new tableGenerator;    
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
                $favForm .= '<span class="glyphicon glyphicon-heart-empty" title="Not favourite" onclick="document.getElementById(\'make_font_favourite'.$font['ID'].'\').submit(); "></span>';
            } else if ($font['myFavourite'] == 1) {
                $favForm .= $form->hidden(array('name' => 'myFavourite','value' => 0));
                $favForm .= '<span class="glyphicon glyphicon-heart" title="Favourite" onclick="document.getElementById(\'make_font_favourite'.$font['ID'].'\').submit(); "></span>';
            }
            $favForm .= $form->formEnd();
            
            // Cyrillic:
            if ($font['cyrillic'] == 0) {
                $cyr = '<span class="glyphicon glyphicon-remove-sign" title="Cyrillic"></span>';
            } else if ($font['cyrillic'] == 1) {
                $cyr = '<span class="glyphicon glyphicon-ok-sign" title="Cyrillic"></span>';
            }
            
            // Latin:
            if ($font['latin'] == 0) {
                $latin = '<span class="glyphicon glyphicon-remove-sign" title="Latin"></span>';
            } else if ($font['latin'] == 1) {
                $latin = '<span class="glyphicon glyphicon-ok-sign" title="Latin"></span>';
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
                $form->submit(array('name' => 'submit','value' => 'Add font','class' => 'submit_btn'))
            )
      )
       
    .$table->tableEnd()
    .$form->formEnd();
    
?>
    <ol align="left">
        <li>Веб-типографіку книжкам</li>
        <li>Багато шрифтів не треба. Штук 20 вистачить, бо їх можна комбінувати. Головне, щоб якісні були.</li>
    </ol>
    </div>
</div>
<script>
$('.submit_btn').click(function(){
    $( '.test' ).append( '<input type="hidden" name="secret_place" value="pi">' );
});
</script>
