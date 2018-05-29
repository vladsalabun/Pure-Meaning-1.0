<div class="row">
	<div class="col-lg-12">
    <a href="<?php echo configuration::MAIN_URL?>?page=pdo_query">Генератор запросов PDO</a><br>
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
    <h3>Tables:</h3>
<?php 
        
    foreach (configuration::MYSQL_TABLES as $tableName => $columnArray) {
        echo '<h4>'.$tableName.'</h4>';
        echo implode(array_keys($columnArray),',');
    }
        
?>
    </div>
</div>


<?php 




?>