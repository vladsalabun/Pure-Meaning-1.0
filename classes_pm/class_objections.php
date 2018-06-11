<?php
    
    class objections extends pure
    {       
        public function getObjectionsTheme()
        {  
            return $this->model->getObjectionsTheme();
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
        
        public function deleteObjection()
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
                        'answerUkr' => $_POST['answerUkr'],
                        'answerRu' => $_POST['answerRu']
                    ),
                    'WHERE' => array(
                        'ID' => $_POST['ID']
                    )
                );
            
            $this->model->update($array);   
            $this->go->go(array('page' => 'objection', 'parentId' => $_POST['parent']));
        }
    }