<?php 

    class database extends PDO
    {
        public $conn;
        
        function __construct() 
        {
            $this->connecting();
            $this->createAllTables();
        }
        
        private function connecting() 
        {
            // Connectiong to db:
            $this->conn = new PDO('mysql:host='.CONFIGURATION::HOST.';dbname='.CONFIGURATION::DB_NAME, CONFIGURATION::DB_USER, CONFIGURATION::DB_PASSWORD);
            $this->conn->exec("set names utf8mb4");
        }    

        private function createAllTables() 
        {
            // Creating tables:
            if (CONFIGURATION::REINSTALL == 1) {
                foreach (CONFIGURATION::MYSQL_TABLES AS $table_name => $value_array) {
                    try 
                    {
                        $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                        foreach ($value_array AS $row_name => $row_option) {
                            $table_params[] = $row_name . ' ' . $row_option;
                        }
        
                        $sql = 'CREATE TABLE IF NOT EXISTS '.$table_name.' ('.implode($table_params, ', ').') ;<br>'; // Create new!
                        $this->conn->exec($sql);
                    }
                    catch(PDOException $e) 
                    {
                        echo $e->getMessage(); // if something go wrong
                    }
                    unset($table_params);
                }
            } elseif (CONFIGURATION::REINSTALL == 2) {
                // Wipe database:
                foreach (CONFIGURATION::MYSQL_TABLES AS $table_name => $value_array) {
                    $sql = "DROP TABLE $table_name";
                    $this->conn->exec($sql);
                }
            }
        }        
        
        // TODO: Create indexes!
        
    } // <- end of class database

    class model extends database 
    {
        public function getAllProjects() 
        {
            $sql = "SELECT * FROM pm_projects WHERE parentId = 0 AND moderation < 3 ORDER BY ID DESC";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);           
        }  
        
        #
        ### SELECT:
        #
        
        public function select($query,$vars = null)
        {    
            if (isset($query['SELECT'])) { 
                $select = $query['SELECT'];
            } else {
                $select = '*';
            }
            if (isset($query['FROM'])) {
                $from = $query['FROM'];
            } else {
                return '<p>ERROR: you must set FROM what table you want select rows.</p>';
            }
            // TODO: what if we get user data? 
            if (isset($query['WHERE'])) {
                $where = 'WHERE '. $query['WHERE'];
            }
            if (isset($query['ORDER'])) {
                if (isset($query['SORT'])) {
                    $order = 'ORDER BY '.$query['ORDER'].' '.$query['SORT'];
                } else {
                    $order = 'ORDER BY '.$query['ORDER'].' ASC';
                }
            } 
            if (isset($query['LIMIT'])) {
                $limit = 'LIMIT '.$query['LIMIT'];
            }
              
            // TODO: ?
            if (is_array($vars)) {
            }
              
            $sql = "SELECT $select FROM $from $where $order $limit";
            $stmt = $this->conn->prepare($sql);    
            if (is_array($vars)) {
                $stmt->execute($vars);
            } else {
                $stmt->execute();
            }
            if ($query['fetch'] == 1) {   
                return $stmt->fetch(PDO::FETCH_ASSOC);  
            } else {
                return $stmt->fetchAll(PDO::FETCH_ASSOC); 
            }
            
        }
        
        ### /SELECT
        
        ### UPDATE:
        
        public function update($array) 
        {
            
            // check what table need to update: 
            if (!isset($array['UPDATE'])) {
                echo 'ERROR UPDATE: what table you want to update?';
                exit();
            }
            
            // TABLE to update:
            $sql .= "UPDATE ".$array['UPDATE']." ";
                
            if (count($array['SET']) < 1 or !isset($array['SET'])) {
                echo 'ERROR UPDATE: what columns in table <b>'.$array['UPDATE'].'</b> you want to update?';
                exit();
            }
            
            // make columns and values arrays:
            foreach ($array['SET'] as $key => $value) {
                $keys[] = $key;
                $values[] = $value;
            }
                
            $sql .= "SET ";
                
            // put columns to query:
            foreach ($keys as $key) {
                $set[] = $key . " = :".$key;
            }
                
            // put values to query:
            $sql .= implode($set,',');
                
            if (isset($array['WHERE'])) {
                    
                $sql .= " WHERE ";
                    
                foreach ($array['WHERE'] as $whereKey => $whereValue) {
                        $keys[] = $whereKey;
                        $whereKeys[] = $whereKey;
                        $values[] = $whereValue;
                }
                
                foreach ($whereKeys as $whereKey) {
                    $where[] = $whereKey . " = :".$whereKey;
                }

                $sql .= implode($where,' AND ');
                
            }
                
            // TODO manual query:
            if (isset($array['MANUAL_WHERE'])) {
                $sql .= " WHERE ...";  
            }
            
            // prepare:       
            $stmt = $this->conn->prepare($sql);
            // bind:
            foreach ($keys as $num => $val) {
                $stmt->bindParam(':'.$val, $values[$num]);
            }
            // and execute:
            $stmt->execute();
            
            $exp = rand(configuration::EXPERIENCE['UPDATE']['min'],configuration::EXPERIENCE['UPDATE']['max']);
            $experience = new experience;
            $experience->addExp($exp);
            
        }
        
        ### /UPDATE
        
        ### INSERT
        public function insert($array) 
        {           
            foreach($array['COLUMNS'] as $columns => $value) {
                $cols[] = $columns;
                $vals[] = $value;
                $questionmarks[] = '?';
            }
            
            // TODO: check for errors. Does the table has such columns? Does it exixts?
            
            $sql = "INSERT INTO ".$array['INSERT INTO']." (".implode($cols,',').") VALUES (".implode($questionmarks,',').")";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($vals);
            
            $exp = rand(configuration::EXPERIENCE['INSERT']['min'],configuration::EXPERIENCE['INSERT']['max']);
            $experience = new experience;
            $experience->addExp($exp);
            
        }
        ### /INSERT

        
        
        
        
        public function getAllSubProjects($parentId) 
        {
            $sql = "SELECT * FROM pm_projects WHERE parentId = ? AND moderation < 3 ORDER BY ID DESC";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute(array($parentId));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);           
        }       
        
        public function getDocumentTree($projectId) 
        {
            $sql = "SELECT * FROM pm_elements WHERE projectId = ? AND moderation != 3 ORDER BY priority DESC";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute(array($projectId));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);  
        }

        public function getElementInfo($elementId)
        {
            $sql = "SELECT * FROM pm_elements WHERE ID = ? LIMIT 1";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute(array($elementId));
            return $stmt->fetch(PDO::FETCH_ASSOC);   
        }
        
        public function addContentBlock($rows,$projectId,$type)
        {
            // TODO:
            $class = 'container';
            $count = 0;
            $priority = $this->lastLowPriority($projectId,0)['priority']; // <- last low priority
   
            for ($i = 0; $i < $rows; $i++) {

                // get next index ID:
                $identifier = 'pm_element'.$this->getNextAutoIncrement();
                
                $sql = "INSERT INTO pm_elements (projectId,type,identifier,class,priority) VALUES (?,?,?,?,?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(array($projectId,$type,$identifier,$class,$priority));    
                $count = $count + $stmt->rowCount();
                $priority--;
            }
            
            return $count;
            
        }
        
        public function getAllChildElements($elementId) {
            $sql = "SELECT * FROM pm_elements WHERE parentId = ?";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute(array($elementId));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);  
        }
        
        public function addNewElement($rows,$projectId,$branchId,$class,$type) 
        {
            // get parentId by ID
            $elementId = substr($branchId,5);
            $parentId = $this->getElementInfo($elementId)['parentId'];
            $priority = $this->lastLowPriority($projectId,$parentId)['priority']; // <- last low priority
            
            for ($i = 0; $i < $rows; $i++) {
                $priority = $priority - 1;

                // get next index ID:
                $identifier = 'pm_element'.$this->getNextAutoIncrement();
                
                $sql = "INSERT INTO pm_elements (projectId,parentId,type,identifier,class,priority) VALUES (?,?,?,?,?,?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(array($projectId,$parentId,$type,$identifier,$class,$priority));
            }
            
        }
        
        public function deleteElement($branchId)
        {
            $stmt = $this->conn->prepare("UPDATE pm_elements SET moderation = 3 WHERE ID = :ID");
            $stmt->bindParam(':ID', $branchId);
            $stmt->execute();
        }
        
        public function favElement($branchId)
        {
            $stmt = $this->conn->prepare("UPDATE pm_elements SET moderation = 1 WHERE ID = :ID");
            $stmt->bindParam(':ID', $branchId);
            $stmt->execute();
        }

        public function changeProjectStyle($projectId,$styleJson)
        {
            $stmt = $this->conn->prepare("UPDATE pm_projects SET globalStyles = :globalStyles WHERE ID = :ID");
            $stmt->bindParam(':ID', $projectId);
            $stmt->bindParam(':globalStyles', $styleJson);
            $stmt->execute();
        }
        
        
        public function updateElementStyle($elementId,$styleJson,$identifier,$class) 
        {
            $stmt = $this->conn->prepare("UPDATE pm_elements SET style = :style, identifier = :identifier, class = :class WHERE ID = :ID");
            $stmt->bindParam(':ID', $elementId);
            $stmt->bindParam(':style', $styleJson);
            $stmt->bindParam(':identifier', $identifier);
            $stmt->bindParam(':class', $class);
            $stmt->execute();
        }
        
        public function deleteElementStyle($elementId,$styleJson) 
        {
            $stmt = $this->conn->prepare("UPDATE pm_elements SET style = :style WHERE ID = :ID");
            $stmt->bindParam(':ID', $elementId);
            $stmt->bindParam(':style', $styleJson);
            $stmt->execute();
        }       
        
        public function getAllClasses($projectId) 
        {
            $sql = "SELECT DISTINCT(class) FROM pm_elements WHERE projectId = ?";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute(array($projectId));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);  
        }

        public function getProjectStyle($projectId)
        {
            $sql = "SELECT globalStyles FROM pm_projects WHERE ID = ?";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute(array($projectId));
            return $stmt->fetch(PDO::FETCH_ASSOC);  
        }
        
        public function addLeaves($parentId,$type,$rows,$class,$projectId)
        {
            $priority = $this->lastLowPriority($projectId,$parentId)['priority'];
            if ( $priority == null) {
                $priority = 0;
            }
  
            for ($i = 0; $i < $rows; $i++) {
                
                // get next index ID:
                $identifier = 'pm_element'.$this->getNextAutoIncrement();
                
                $priority = $priority - 1;
                $sql = "INSERT INTO pm_elements (projectId,parentId,type,identifier,class,priority) VALUES (?,?,?,?,?,?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(array($projectId,$parentId,$type,$identifier,$class,$priority));
            }
        }
        
        public function lastLowPriority($projectId,$parentId)
        {
            $sql = "SELECT * FROM pm_elements WHERE projectId = ? AND parentId = ? ORDER BY priority ASC LIMIT 1";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute(array($projectId,$parentId));
            $array = $stmt->fetch(PDO::FETCH_ASSOC);
            if (is_array($array)) {
                return $array;
            }
            else {
                return array('priority' => 0);
            }            
        }
        
        public function updateBlockPriority($blockId, $priority) 
        {
            $stmt = $this->conn->prepare("UPDATE pm_elements SET priority = :priority WHERE ID = :ID");
            $stmt->bindParam(':ID', $blockId);
            $stmt->bindParam(':priority', $priority);
            $stmt->execute();
        }
        
        public function getNextAutoIncrement() {
            $stmt= $this->conn->query("SHOW TABLE STATUS LIKE 'pm_elements'");
            $next = $stmt->fetch(PDO::FETCH_ASSOC);
            return $next['Auto_increment'];
        }
        
        public function globalStyles($projectId) 
        {
            $sql = "SELECT globalStyles FROM pm_projects WHERE ID = ?";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute(array($projectId));
            return $stmt->fetch(PDO::FETCH_ASSOC);  
        }
        
        public function changeParent($branchId,$newParent)
        {
            $stmt = $this->conn->prepare("UPDATE pm_elements SET parentId = :parentId WHERE ID = :ID");
            $stmt->bindParam(':parentId', $newParent);
            $stmt->bindParam(':ID', $branchId);
            $stmt->execute();
        }
        
        public function getFormById($formId)
        {
            $sql = "SELECT * FROM pm_forms WHERE ID = ?";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute(array($formId));
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        }
        
        public function getForms() 
        {
            $sql = "SELECT * FROM pm_forms WHERE moderation < 3 ORDER BY ID desc";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute(array($formId));
            return $stmt->fetchALL(PDO::FETCH_ASSOC); 
        }
        
        public function addNewForm($projectId,$formJson) 
        {
            $sql = "INSERT INTO pm_forms (projectID,formJson) VALUES (?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array($projectId,$formJson));    
        }
        
        public function deleteForm($formId)
        {
            $stmt = $this->conn->prepare("UPDATE pm_forms SET moderation = 3 WHERE ID = :ID");
            $stmt->bindParam(':ID', $formId);
            $stmt->execute();
        }
        
        public function favForm($formId)
        {
            $stmt = $this->conn->prepare("UPDATE pm_forms SET moderation = 1 WHERE ID = :ID");
            $stmt->bindParam(':ID', $formId);
            $stmt->execute();
        }    

        public function addNewColor($color) 
        {
            $sql = "INSERT INTO pm_colors (color) VALUES (?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array($color));  
        }
        public function getAllColors() 
        {
            $sql = "SELECT * FROM pm_colors WHERE moderation < 3 ORDER BY ID desc";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute(array());
            return $stmt->fetchALL(PDO::FETCH_ASSOC); 
        }
        
        public function addNewFont($fontFamily,$fileName,$fileType)
        {
            $sql = "INSERT INTO pm_fonts (fontFamily,fileName,fileType) VALUES (?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array($fontFamily,$fileName,$fileType));
        }
        
        public function getAllFonts()
        {
            $sql = "SELECT * FROM pm_fonts WHERE moderation < 3 ORDER BY ID desc";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute(array());
            return $stmt->fetchALL(PDO::FETCH_ASSOC); 
        }
        
        public function getFont($fontId)
        {
            $sql = "SELECT * FROM pm_fonts WHERE moderation < 3 AND ID = ?";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute(array($fontId));
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        }
        
        public function makeFontFavourite($fontID,$myFavourite)
        {
            $stmt = $this->conn->prepare("UPDATE pm_fonts SET myFavourite = :myFavourite WHERE ID = :ID");
            $stmt->bindParam(':myFavourite', $myFavourite);
            $stmt->bindParam(':ID', $fontID);
            $stmt->execute();
        }
        
        public function cyrillicFont($fontID,$cyrillic)
        {
            $stmt = $this->conn->prepare("UPDATE pm_fonts SET cyrillic = :cyrillic WHERE ID = :ID");
            $stmt->bindParam(':cyrillic', $cyrillic);
            $stmt->bindParam(':ID', $fontID);
            $stmt->execute();
        }

        public function latinFont($fontID,$latin)
        {
            $stmt = $this->conn->prepare("UPDATE pm_fonts SET latin = :latin WHERE ID = :ID");
            $stmt->bindParam(':latin', $latin);
            $stmt->bindParam(':ID', $fontID);
            $stmt->execute();
        } 

        public function deleteFont($fontID)
        {
            $stmt = $this->conn->prepare("UPDATE pm_fonts SET moderation = 3 WHERE ID = :ID");
            $stmt->bindParam(':ID', $fontID);
            $stmt->execute();
        }  
        
        public function deleteColor($colorID)
        {
            $stmt = $this->conn->prepare("UPDATE pm_colors SET moderation = 3 WHERE ID = :ID");
            $stmt->bindParam(':ID', $colorID);
            $stmt->execute();
        }
        
        public function addNewProject($title, $customer, $skype, $phone1, $phone2, $phone3, $email1, $email2, $vk, $fb, $price, $currency, $workBegin, $workEnd)
        {
            $sql = "INSERT INTO pm_projects (title, customer, skype, phone1, phone2, phone3, email1, email2, vk, fb, price, currency, workBegin, workEnd) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array($title, $customer, $skype, $phone1, $phone2, $phone3, $email1, $email2, $vk, $fb, $price, $currency, $workBegin, $workEnd));
        }
        
        public function addNewSubproject($title, $parentId)
        {
            $sql = "INSERT INTO pm_projects (title, parentId) VALUES (?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array($title, $parentId));
        }
        
        public function editSubproject($title, $projectId)
        {
            $stmt = $this->conn->prepare("UPDATE pm_projects SET title = :title WHERE ID = :ID");
            $stmt->bindParam(':ID', $projectId);
            $stmt->bindParam(':title', $title);
            $stmt->execute();      
        }
        
        public function editProject($post)
        {
            $stmt = $this->conn->prepare("UPDATE pm_projects SET title = :title, customer = :customer, skype = :skype, phone1 = :phone1, phone2 = :phone2, phone3 = :phone3, email1 = :email1, email2 = :email2, vk = :vk, fb = :fb, price = :price, currency = :currency, workBegin = :workBegin, workEnd = :workEnd WHERE ID = :ID");
            $stmt->bindParam(':title', $post['title']);
            $stmt->bindParam(':customer', $post['customer']);
            $stmt->bindParam(':skype', $post['skype']);
            $stmt->bindParam(':phone1', $post['phone1']);
            $stmt->bindParam(':phone2', $post['phone2']);
            $stmt->bindParam(':phone3', $post['phone3']);
            $stmt->bindParam(':email1', $post['email1']);
            $stmt->bindParam(':email2', $post['email2']);
            $stmt->bindParam(':vk', $post['vk']);
            $stmt->bindParam(':fb', $post['fb']);
            $stmt->bindParam(':price', $post['price']);
            $stmt->bindParam(':currency', $post['currency'][0]);
            $stmt->bindParam(':workBegin', strtotime($post['workBegin']));
            $stmt->bindParam(':workEnd', strtotime($post['workEnd']));
            $stmt->bindParam(':ID', $post['projectId']);
            $stmt->execute();
        }
        
        public function deleteProject($projectId)
        {
            $stmt = $this->conn->prepare("UPDATE pm_projects SET moderation = 3 WHERE ID = :ID");
            $stmt->bindParam(':ID', $projectId);
            $stmt->execute();
        }
        
        public function getObjectionsTheme()
        {
            $sql = "SELECT * FROM pm_objections WHERE parentId = 0 AND moderation < 3 ORDER BY ID desc";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute();
            return $stmt->fetchALL(PDO::FETCH_ASSOC); 
        }
        
        public function objectionsThemeCount($objectionID)
        {
            $sql = "SELECT * FROM pm_objections WHERE parentId = ? AND moderation < 3 ORDER BY ID desc";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute(array($objectionID));
            return $stmt->rowCount(); 
        }
        
        public function addNewObjectionTheme($theme)
        {
            $sql = "INSERT INTO pm_objections (objection) VALUES (?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array($theme));
        }
        
        public function deleteObjection($objectionId)
        {
            $stmt = $this->conn->prepare("UPDATE pm_objections SET moderation = 3 WHERE ID = :ID");
            $stmt->bindParam(':ID', $objectionId);
            $stmt->execute();
        }
        
        public function getObjectionBranch($parentId)
        {
            $sql = "SELECT * FROM pm_objections WHERE parentId = ? AND moderation < 3 ORDER BY ID desc";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute(array($parentId));
            return $stmt->fetchALL(PDO::FETCH_ASSOC); 
        }

        public function addExp($newExp)
        {
            $sql = "SELECT * FROM pm_experience ORDER BY ID DESC LIMIT 1";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute(array());
            $allExp = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['allExp'] + $newExp; 
            
            $sql = "INSERT INTO pm_experience (newExp,allExp,time) VALUES (?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array($newExp,$allExp,mktime()));
        }
        
        public function allExp()
        {
            $sql = "SELECT * FROM pm_experience ORDER BY ID DESC LIMIT 1";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute(array());
            return $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['allExp']; 
        }
        
        /*
        public function insert($table,$values) 
        {
            foreach ($values as $columnName => $columnValue) {
                $columnArray[] = $columnName;
                $valueArray[] = $columnValue;
                $questionMark[] = '?';
            }
            
            $sql = "INSERT INTO $table (".implode($columnArray,',').") VALUES (".implode($questionMark,',').")";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array($valueArray));
        }
        */
        
        
    } // <- end of class model 
