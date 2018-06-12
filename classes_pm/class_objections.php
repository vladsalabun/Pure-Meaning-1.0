<?php
    
    class objections extends pure
    {       
        public function getObjectionsTheme()
        {  
            return $this->model->getObjectionsTheme();
        } 

        public function getObjection($ID)
        {  
            $array = array(
                'SELECT' => '*',
                'FROM' => 'pm_objections',
                'WHERE' => 'ID = ' . $ID,
                'fetch' => 1
            );
            return $this->model->select($array, null);
        }
        
        public function objectionsThemeCount($objectionID)
        {  
            return $this->model->objectionsThemeCount($objectionID);
        }       
        
        public function addNewObjectionTheme()
        {
            $this->model->addNewObjectionTheme($_POST['theme']);
            $this->go->go('objections');            
        }
        
        public function deleteObjectionTheme()
        {
            $this->model->deleteObjection($_POST['objection']);
            $this->go->go('objections');
        }
        
        public function getObjectionBranch($parentId)
        {
            return $this->model->getObjectionBranch($parentId);
        }
        
        public function editObjection()
        {           
            $array = array(
                    'UPDATE' => 'pm_objections',
                    'SET' => array(
                        'objection' => $_POST['objection'],
                        'answerUkr' => $_POST['answerUkr'],
                        'answerRu' => $_POST['answerRu']
                    ),
                    'WHERE' => array(
                        'ID' => $_POST['ID']
                    )
                );
            
            $this->model->update($array);   
            $this->go->go(array('page' => 'objection', 'parentId' => $_POST['parentId']));
        }
        
        public function addObjection()
        {
            $array = array(
                'INSERT INTO' => 'pm_objections',
                'COLUMNS' => array(
                        'parentId' => $_POST['parentId'],
                        'objection' => $_POST['objection'],
                        'answerUkr' => $_POST['answerUkr'],
                        'answerRu' => $_POST['answerRu']
                 )
            );
            $this->model->insert($array);
            $this->go->go(array('page' => 'objection', 'parentId' => $_POST['parentId']));
        }
        
        public function deleteObjection()
        {
             $array = array(
                    'UPDATE' => 'pm_objections',
                    'SET' => array(
                        'moderation' => 3,
                    ),
                    'WHERE' => array(
                        'ID' => $_POST['ID']
                    )
                );
            
            $this->model->update($array);   
            $this->go->go(array('page' => 'objection', 'parentId' => $_POST['parentId']));
        }
        
    }