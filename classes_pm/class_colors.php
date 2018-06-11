<?php
    
    class colors extends pure
    {       
        public function addNewColor()
        {
            if (strlen($_POST['color']) > 0) {
                $this->model->addNewColor($_POST['color']);
            }
            $this->go->go('colors');
        }
        
        public function getAllColors()
        {
            return $this->model->getAllColors();
        }
        
        public function deleteColor()   
        {
            $this->model->deleteColor($_POST['colorID']);
            $this->go->go('colors');          
        }
    }