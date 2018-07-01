
<div class="row">
	<div class="col-lg-8">
    <h3>Templatter:</h3>
    <pre>
<?php
    echo Highlight::render(
    "
    \$table->tableStart(array('th' => array('',''),'class' => 'table table-sm table-mini'));
    \$table->tr(array('',''));
    \$table->tr(array(2,'')); // розтягнути на дві колонки
    \$table->tableEnd();

    \$modal->a('window','anchor'); // посилання на модальне вікно
    
    \$form->formStart();
    \$form->hidden(array('name'=> '','value'=> ''));
    \$form->text(array('name'=> '','value'=> '','class'=>'txtfield','placeholder' =>''));
    \$form->textarea(array('name'=> '','value'=> '','class'=>'txtfield'));
    \$form->uploadFile(array('name'=> ''));
    \$form->select(array('name'=> '','value'=> array('key'=>'value')));
    \$form->datetime(array('name'=> '','value'=> ''))
    \$form->submit(array('name'=> '','value'=> '','class'=>'btn'));
    \$form->formEnd();
    
    # Вибір шрифтa:
        \$form->fontSelectingForm(\$idCssValue,'id_'.\$idName.'_'.\$idCssName)
    
    # HTML: 
        p('text');
        modalLink('windowId', 'anchor');
        modalWindow('windowId','text in modal header','modal body');
    "
    );
?>
    </pre>
    <h3>Bootstrap:</h3>
    <b>.container-fluid</b> - контейнер на ширину екрану
    
    </div>
    <div class="col-lg-4">
        <h3>Query generator:</h3>
    <ol>
<?php 

    foreach (configuration::MYSQL_TABLES as $tableName => $columnArray) {
        
        echo '<li>
        '.$tableName.': 
        <a href="" data-toggle="modal" data-target="#select_'.$tableName.'">select</a> :
        <a href="" data-toggle="modal" data-target="#update_'.$tableName.'">update</a> : 
        <a href="" data-toggle="modal" data-target="#insert_'.$tableName.'">insert</a>
        </li>'; 

        $select = renderSelect($tableName,$columnArray);
        $update = renderUpdate($tableName,$columnArray);
        $insert = renderInsert($tableName,$columnArray);
        
        echo $pure->modalHtml('select_'.$tableName,'<h3>SELECT FROM: '.$tableName.'</h3>',$select); 
        echo $pure->modalHtml('update_'.$tableName,'<h3>UPDATE: '.$tableName.'</h3>',$update); 
        echo $pure->modalHtml('insert_'.$tableName,'<h3>INSERT INTO: '.$tableName.'</h3>',$insert); 
        
    }
        
?>
    </ol>
        <h3>Notepad++ shortkeys:</h3>
    
    F11 - на весь экран<br>
    Ctrl + Q - закомментировать/раскомментировать<br>
    Ctrl + Shift + Q - закомментировать выделенное<br>
    Tab - добавить табуляции выделенного фрагмента<br>
    Shift + Tab - удалить табуляции выделенного фрагмента<br>
    Ctrl + U - строчные<br>
    Ctrl + Shift + U - прописные<br>
    Alt + U - Все с заглавной<br>
    Ctrl + Shift + Up/Down - переместить строку вверх/вниз<br>
        <h4>Суть шрифтів:</h4>
    <ol align="left">
    <li>Щоб на ньому текст був читабельним</li>
    <li>Щоб виділити важливу інформацію</li>
    <li>Щоб оку приємно було читати</li>
    </ol>
    </div>
</div>
<?php 
   
    /*
    * @param (string) file name or string of PHP code to be highlighted
    * @param (bool) set to true if @param1 is a file
    * @param (bool) allow caching of processed text (currently work for files only)
    */   
   
        ###
        function renderSelect($tableName,$columnArray) {

return '<pre align="left">'. 
Highlight::render(
'public function '.$tableName.'()
{  
    $array = array(
        "SELECT" => "*",
        "FROM" => "'.$tableName.'",
        "WHERE" => "ID = 1",
        //"fetch" => 1,
        //"ORDER" => "ID",
        //"SORT" => "DESC",
    );
    return $this->model->select($array, null);
            
    // '.$tableName.' fields:
    // '.implode(array_keys($columnArray),', ').'       
}', false, true). '</pre>';        

        }

        ###
        function renderUpdate($tableName,$columnArray) {

        foreach($columnArray as $column => $param) {
            $set[] = '"'.$column.'" => $_POST[\''.$column.'\']';
        }
        
return '<pre align="left">'. 
Highlight::render(
'public function '.$tableName.'()
{  
    $array = array(
        "UPDATE" => \''.$tableName.'\',
        "SET" => array(
            '.implode($set,',
            ').'
        ),
        "WHERE" => array(
            "ID" => $_POST[\'ID\']
        ),
        // "MANUAL_WHERE" => ""
    );
            
    $this->model->update($array); 
    // page to redirect:    
    $this->go->go(\''.$tableName.'\');
            
    // '.$tableName.' fields:
    // '.implode(array_keys($columnArray),', ').'       
}', false, true). '</pre>';        

        }
        
        ###
        function renderInsert($tableName,$columnArray)
        {
            
        foreach($columnArray as $column => $param) {
            $set[] = '"'.$column.'" => $_POST[\''.$column.'\']';
        }  
            
return '<pre align="left">'. 
Highlight::render(   
'public function '.$tableName.'()
{
    $array = array(
        "INSERT INTO" => \''.$tableName.'\',
        "COLUMNS" => array(
            '.implode($set,',
            ').'
        )
    );
    $this->model->insert($array);
    $this->go->go(\''.$tableName.'\');
}
    // '.$tableName.' fields:
    // '.implode(array_keys($columnArray),', ').'       
    ', false, true). '</pre>'; 
}
