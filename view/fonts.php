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
    <p>На цій сторінці модерація шрифтів. Я закидую шрифти у папку uploads/fonts. Тут дивлюсь що з них вийшло, і видаляю, або додаю у базу даних. Тоді файл переноситься у спеціальну папку.</p>
    <p align="left">В чому суть шрифтів?
    <ol align="left">
    <li>Щоб на ньому текст був читабельним</li>
    <li>Щоб виділити важливу інформацію</li>
    <li>Щоб оку приємно було читати</li>
    <li>Що ще?</li>
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
    <ol align="left">
        <li>Шрифти завантажуй по 1. Інакше не вийде. Загрузим, побачив превю, і якщо все ок - додав опис і зберіг.</li>
        <li>Зберігай усі добре згенеровані дизайни у базу</li>
        <li>Історія змін</li>
        <li>Можна генерувати повністю всі CSS стилі, і називати їх нормально: "Ширина, фон, шрифт"</li>
        <li>Попередній перегляд згенерованого коду</li>
        <li>Чи можливо генерувати окремо хедер, окремо футер, окремо боді, окремо різні сторінки? А потім зберегти у відповідні файли</li>
        <li>Правила веб-типографіки можна вивчити по вікіпедії і книжкам</li>
        <li>Багато шрифтів не треба. Штук 20 вистачить, бо їх можна комбінувати. Головне, щоб якісні були.</li>
        
    </ol>
    
    </div>
</div>



