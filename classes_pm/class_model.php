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
            $sql = "SELECT * FROM pm_projects";
            $stmt = $this->conn->prepare($sql);    
            $stmt->execute(array($user_id));
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
        
        public function addContentBlock($rows,$projectId)
        {
            $class = 'row';
            $type = 2;
            $count = 0;
            $priority = $this->lastLowPriority($projectId,0)['priority']; // <- last low priority
            
            for ($i = 0; $i < $rows; $i++) {
                $sql = "INSERT INTO pm_elements (projectId,type,class,priority) VALUES (?,?,?,?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(array($projectId,$type,$class,$priority));    
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
        
        public function addNewElement($rows,$projectId,$branch_id,$identifier,$class) 
        {
            // get parentId by ID
            $elementId = substr($branch_id,5);
            $parentId = $this->getElementInfo($elementId)['parentId'];
            $type = 2;
            $priority = $this->lastLowPriority($projectId,$parentId)['priority']; // <- last low priority
            
            for ($i = 0; $i < $rows; $i++) {
                $priority = $priority - 1;
                $sql = "INSERT INTO pm_elements (projectId,parentId,type,identifier,class,priority) VALUES (?,?,?,?,?,?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(array($projectId,$parentId,$type,$identifier,$class,$priority));
            }
            
        }

        public function addLeaves($parentId,$type,$rows,$identifier,$class,$projectId)
        {
            $priority = $this->lastLowPriority($projectId,$parentId)['priority'];
            if ( $priority == null) {
                $priority = 0;
            }
  
            for ($i = 0; $i < $rows; $i++) {
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
            return $stmt->fetch(PDO::FETCH_ASSOC);   
        }
        
        public function updateBlockPriority($blockId, $priority) 
        {
            $stmt = $this->conn->prepare("UPDATE pm_elements SET priority = :priority WHERE ID = :ID");
            $stmt->bindParam(':ID', $blockId);
            $stmt->bindParam(':priority', $priority);
            $stmt->execute();
        }
        
        
    } // <- end of class model 
