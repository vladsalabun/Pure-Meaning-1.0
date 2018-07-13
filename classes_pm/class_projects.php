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
        
        public function getProjectInfo($projectId) 
        {
            $query = array(
                "SELECT" => "*",
                "FROM" => "pm_projects",
                "WHERE" => "ID = '$projectId'"
            );
            return $this->model->select($query);
        }
        
        public function addNewProject()  
        {
            // insert new project to database and get last ID:
            $lastInsertedID = $this->model->addNewProject(
                $_POST['title'], $_POST['customer'], $_POST['skype'],
                $_POST['phone1'], $_POST['phone2'], $_POST['phone3'],
                $_POST['email1'], $_POST['email2'], $_POST['vk'],
                $_POST['fb'], $_POST['price'], $_POST['currency'][0],
                strtotime($_POST['workBegin']), strtotime($_POST['workEnd'])
            );

            // if WordPress:
            if ($_POST['project_type'][0] == 0) {
                foreach (configuration::WORDPRESS_PAGES as $page) {
                    $this->model->addNewSubproject($page,$lastInsertedID);
                }
            } else if($_POST['project_type'][0] == 99) {
                // if custom:
            }

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

        public function duplicateProject() 
        {
            // get project info:
            $projectInfo = $this->getProjectInfo($_POST['projectId']);
            // copy and insert it: 
/*            
            $array = array(
                "INSERT INTO" => 'pm_projects',
                "COLUMNS" => array(
                    "parentId" => $projectInfo[0]['parentId'],
                    "title" => $projectInfo[0]['title'].'_duplicated',
                    "customer" => $projectInfo[0]['customer'],
                    "skype" => $projectInfo[0]['skype'],
                    "phone1" => $projectInfo[0]['phone1'],
                    "phone2" => $projectInfo[0]['phone2'],
                    "phone3" => $projectInfo[0]['phone3'],
                    "email1" => $projectInfo[0]['email1'],
                    "email2" => $projectInfo[0]['email2'],
                    "vk" => $projectInfo[0]['vk'],
                    "fb" => $projectInfo[0]['fb'],
                    "price" => $projectInfo[0]['price'],
                    "currency" => $projectInfo[0]['currency'],
                    "workBegin" => $projectInfo[0]['workBegin'],
                    "workEnd" => $projectInfo[0]['workEnd'],
                    "done" => $projectInfo[0]['done'],
                    "moderation" => $projectInfo[0]['moderation'],
                    "globalStyles" => $projectInfo[0]['globalStyles']
                )
            );
            $this->model->insert($array);
*/            
            // copy elements
            
            // take full tree:
            $htmlTree = $this->getDocumentTree($_POST['projectId']);
            // clean:
            $cleanArray = $this->cleanLeaves($this->createTreeArray($htmlTree));
            
            var_dump($cleanArray);
            // get copied branch:
            //$copiedBranch = $this->getBranch($cleanArray, 'block'.$bufferElement['elementID']);
            
            exit();
        }
       
    }