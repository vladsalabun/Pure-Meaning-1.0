<div class="row">
	<div class="col-lg-8">
    <p align="left">Тут модерую кольори фонів і текстів. Шрифт текста беру з уже промодерованих шрифтів. Всі кольори поєднуються випадковим чином і добрі/погані пари записуються у базу даних.</p>
    <p align="left">Суть фона:
    <ol align="left">
    <li>Щоб на ньому текст був читабельним</li>
    <li>Щоб виділити важливу інформацію</li>
    </ol>
    </p> 
     <?php 
            
            // is it important to know color names?
            
            $backgroundColors = array(
                // background => font color
                '#559E54' => '#F7E7D4',
                '#FF6633' => '#FFFFFF',
                '#C21460' => '#F7E7D4',
                '#e6e6e6' => '#1258DC',
                '#1258DC' => '#e6e6e6',
                '#669999' => '#FFFFFF',
                '#1258DC' => '#00CCFF',
                '#1258DC' => '#00CCFF'
            );
        
        
            foreach($backgroundColors as $backgroundColor => $fontColor) {
                
                echo '<div style="width:200px;padding:10px;float:left;
                background:'.$backgroundColor.';font-size:13px;color:'.$fontColor.'">
                '.$fontColor.'
                </div>';
                
            }
        
        ?>
    </div>
	<div class="col-lg-4">
        
    </div>
</div>