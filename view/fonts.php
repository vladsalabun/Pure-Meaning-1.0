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
    <p align="left">Суть шрифтів:
    <ol align="left">
    <li>Щоб на ньому текст був читабельним</li>
    <li>Щоб виділити важливу інформацію</li>
    <li>Щоб оку приємно було читати</li>
    </ol>
    
    <style>
    @font-face{font-family:<?php echo $fontFamily;?>;src:url(uploads/fonts/<?php echo $fontFamily;?>.ttf)}
    #test { 
        font-family: <?php echo $fontFamily;?>; 
        font-size: <?php echo $fontSize; ?>px; 
        background: #<?php echo $blockBackground; ?>; 
        overflow: hidden; 
        height: <?php echo $blockHeight; ?>px; width: <?php echo $blockWidth; ?>px;
        margin-left: auto;
        margin-right: auto;
        position: relative;
        color: #<?php echo $textColor; ?>;
    }
    #test_inner {
        margin: 10px;
        position: absolute;
        top: 45%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%);
    }
    </style>
        <div id="test">
        <div id="test_inner">Lorem Ipsum! Привет мир! Lorem Ipsum! Привет мир! Lorem Ipsum! Привет мир! Lorem Ipsum!</div>
        </div>
    
    </div>
	<div class="col-lg-4">
    <h4>Add new font:</h4>
<?php
 echo 
     $form->formStart()
    .$table->tableStart(array('class'=>'table table-striped','th'=> array('#','#')))
    .$form->hidden(array('name' => 'action','value' => 'add_new_font'))
    .$table->tr(
            array(
                'color',
                $form->text(array('name' => 'color','placeholder' => '#000'))
            )
        )
    .$table->tr(
            array(
                'Тон',
                $form->text(array('name' => 'ton'))
            )
        )        
    .$table->tr(
            array(
                'Асоциации:',
                $form->text(array('name' => 'assoc',))
            )
        )
    .$table->tr(
            array(
                'Категория:',
                $form->text(array('name' => 'category',))
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
        <li>Шрифти завантажуй по 1.</li>
        <li>Веб-типографіку книжкам</li>
        <li>Багато шрифтів не треба. Штук 20 вистачить, бо їх можна комбінувати. Головне, щоб якісні були.</li>
    </ol>
    
    </div>
</div>



