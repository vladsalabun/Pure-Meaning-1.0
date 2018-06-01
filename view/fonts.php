<?php 
    $form = new formGenerator;    
    $table = new tableGenerator;    
?>
<?php 
    
    if (isset($_GET['font_family'])) {
        $fontFamily = $_GET['font_family'];
    } else {
       $fontFamily = 'Arial'; 
    }
    if (isset($_GET['block_height'])) {
        $blockHeight = $_GET['block_height'];
    } else {
        $blockHeight = 400;
    }
    if (isset($_GET['block_width'])) {
        $blockWidth = $_GET['block_width'];
    } else {
        $blockWidth = 400;
    }
   
    if (isset($_GET['block_background'])) {
        $blockBackground = $_GET['block_background'];
    } else {
        $blockBackground = 'ffffff';
    }
    
    if (isset($_GET['text_color'])) {
        $textColor = $_GET['text_color'];
    } else {
        $textColor = '000000';
    }
    
    if (isset($_GET['font_size'])) {
        $fontSize = $_GET['font_size'];
    } else {
        $fontSize = 17;
    }


?>
<div class="row">
	<div class="col-lg-8">
    <?php 
        $fonts = $pure->getAllFonts();
        echo $table->tableStart( array(
                'class'=>'table table-striped',
                'th'=> array('ID:','Family:','Style:','Variant','Weight','Cyryllic:','Latin','File:','Type:')
                )
            );
        
        foreach ($fonts as $font) {
            echo $table->tr(
                array(
                    $font['ID'],
                    '<a href="'.CONFIGURATION::MAIN_URL.'?page=font&ID='.$font['ID'].'">'.$font['fontFamily'].'</a>',
                    '',
                    '',
                    '',
                    '',
                    '',
                    $font['fileName'],
                    $font['fileType']
                )
            );
        }
        echo $table->tableEnd();
    
    ?>
    </div>
	<div class="col-lg-4">
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
                $form->text(array('name' => 'font_name'))
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



