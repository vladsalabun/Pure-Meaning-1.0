<?php
    
    class projects extends pure
    {
        public function getAllProjects() 
        {  
            $query = array(
                'SELECT' => '*',
                'FROM' => 'pm_projects',
                'WHERE' => 'parentId = 0 AND moderation < 3',
                'ORDER' => 'ID',
                'SORT' => 'DESC',
            );
            return $this->model->select($query);
        }
 
        public function getAllSubProjects($projectId) 
        {
            return $this->model->getAllSubProjects($projectId);
        }
        
        public function addNewProject()  
        {
            $this->model->addNewProject(
                $_POST['title'], $_POST['customer'], $_POST['skype'],
                $_POST['phone1'], $_POST['phone2'], $_POST['phone3'],
                $_POST['email1'], $_POST['email2'], $_POST['vk'],
                $_POST['fb'], $_POST['price'], $_POST['currency'][0],
                strtotime($_POST['workBegin']), strtotime($_POST['workEnd'])
            );
            
            $this->go->go('projects'); 
        } 

        public function deleteProject()
        {
            $this->model->deleteProject($_POST['projectId']);
            $this->go->go('projects');
        }

        public function addNewSubproject()
        {
            $this->model->addNewSubproject($_POST['title'],$_POST['projectId']);
            $this->go->go('projects');
        }  

        public function editSubproject()
        {
            $this->model->editSubproject($_POST['title'],$_POST['projectId']);
            $this->go->go('projects');
        }  

        public function editProject()
        {
            $this->model->editProject($_POST);
            $this->go->go('projects');
        }         
       
    }