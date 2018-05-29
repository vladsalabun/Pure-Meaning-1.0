<div class="row">
	<div class="col-lg-12" style="font-size: 17px;">
    <pre>
<?php 

    //$this->model;
    
    // TODO: check if count variables == count ?
    
    // ACTION: 
    if ($post['action'] == 'generate_pdo') {
        
        // IF SELECT:
        if ($post['whatToDo'] == 'select') {
            foreach ($post as $key => $value) {
                $tmp .= $value;
                $linkParam .= '&'.$key.'='.$value;
            }
            
            $parts = explode('?', $tmp);  
            $partsCount = count($parts) - 1;
            
            if (strlen($post['variables']) > 0) {
                $vars_array = explode(',',$post['variables']);
                foreach ($vars_array as $var) {
                    $varExecuteArray[] = '$'.$var;
                }
            } else {
                $vars_array = null;
            }
            
            $count_vars = count($vars_array);
            
            if ( $count_vars == $partsCount) {
                echo 'vars = quest_mark<br>';
            } else {
                echo '<p><font color="red">ERROR!</font> Variables: '.$count_vars.' Question Marks: '.$partsCount.'</p>';
            }
            
            //TODO: configuration::MYSQL_TABLES;
            
            $whatToDo = 'SELECT';
            if (strlen($post['columns']) > 0) {
                // TODO: check if columns exists
                $columns = ' '.$post['columns'];
            } else {
                $columns = ' *';
            }
            if (strlen($post['condition']) > 0) {
                $condition = ' '.$post['condition'];
            }
            if (strlen($post['orderBy']) > 0) {
                $orderBy = ' ORDER BY '.$post['orderBy'].' '.$post['ascdesc'];
            }
            if ($post['limit'] > 0) {
                $limit = ' LIMIT '.$post['limit'];
            }
            
            // TODO: if * = check if columns exists
            $table = $post['table'];
            
            $sql = $whatToDo.$columns.' FROM '.$table.$condition.$orderBy.$limit;
            
           
            
        } else if ( $post['whatToDo'] == 'update') {
            // IF UPDATE
            $whatToDo = 'UPDATE';
            $sql = $whatToDo.' '.$post['table'].' WHERE ID = ? LIMIT 1';
            
        } else if ( $post['whatToDo'] == 'insert') {
            // IF ISERT:
            $whatToDo = 'INSERT';
        }
        
        $str .= 'public function methodName($var1)
        {
            $sql = "'.$sql.'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array('.implode($varExecuteArray,',').'));
            return $stmt->fetch(PDO::FETCH_ASSOC);   
        }';
    
        // show code:
        echo $str;
    
    } // <--- END OF ACTION
?>
    </pre>
    </div>
    <p><a href="<?php echo configuration::MAIN_URL?>?page=pdo_query<?php echo $linkParam; ?>">Вернутся в форму</a></p>
</div>
<?php 

    var_dump($post);
        
?>



