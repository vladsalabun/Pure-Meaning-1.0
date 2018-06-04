<?php 
    $form = new formGenerator;    
    $table = new tableGenerator;    
?>
<div class="row">
	<div class="col-lg-8 col-sm-9">
    <?php 
        $fonts = $pure->getAllFonts();
        echo $table->tableStart( array(
                'class'=>'table table-striped',
                'th'=> array('ID:','Fav:','Family:','Cyr:','Lat','Type:')
                )
            );
        
        foreach ($fonts as $font) {
            
            // Favourite:
            if ($font['myFavourite'] == 0) {
                $fav = '<span class="glyphicon glyphicon-heart-empty" title="Not favourite"></span>';
            } else if ($font['myFavourite'] == 1) {
                $fav = '<span class="glyphicon glyphicon-heart" title="Favourite"></span>';
            }
            
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
                    $fav,
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
    .$table->tableStart(array('class'=>'table table-striped','th'=> array('#','#')))
    .$form->hidden(array('name' => 'action','value' => 'add_new_font'))
    .$form->hidden(array('name' => 'MAX_FILE_SIZE','value' => '20485760'))
    .$table->tr(
            array(
                'Font name',
                $form->text(array('name' => 'font_name','class' => 'test'))
            )
        )
     .$table->tr(
            array(
                '',
                $form->uploadFile()
            )
        )
      .$table->tr(
            array(
                '',
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
