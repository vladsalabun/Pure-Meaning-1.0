<div class="row">
	<div class="col-lg-12">
    <h4>Notepad++ shortkeys:</h4>
    
    F11 - на весь экран<br>
    Ctrl + Q - закомментировать/раскомментировать<br>
    Ctrl + Shift + Q - закомментировать выделенное<br>
    Tab - добавить табуляции выделенного фрагмента<br>
    Shift + Tab - удалить табуляции выделенного фрагмента<br>
    Ctrl + U - строчные<br>
    Ctrl + Shift + U - прописные<br>
    Alt + U - Все с заглавной<br>
    Ctrl + Shift + Up/Down - переместить строку вверх/вниз<br>
    <h3>Query generator:</h3>
    <ol>
<?php 
     
    foreach (configuration::MYSQL_TABLES as $tableName => $columnArray) {
        echo '<li>'.$tableName.': <a href="">select</a> / <a href="">update</a> / <a href="">insert</a></li>'; 
        //echo '<h4>'.$tableName.'</h4>';
        //echo implode(array_keys($columnArray),',');
    }
        
?>
    </ol>
    <h4>Суть шрифтів:</h4>
    <ol align="left">
    <li>Щоб на ньому текст був читабельним</li>
    <li>Щоб виділити важливу інформацію</li>
    <li>Щоб оку приємно було читати</li>
    </ol>
    </div>
</div>


<?php 




?>